<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Plugins extends Page
{
    protected static ?string $navigationIcon = 'phosphor-plugs-duotone';

    protected static string $view = 'filament.pages.plugins';

    protected static ?int $navigationSort = 9;

    public $plugins = [];

    public function mount(): void
    {
        $this->refreshPlugins();
    }

    public function activate(string $pluginFolder): void
    {
        $installedPlugins = $this->getInstalledPlugins();

        if (! in_array($pluginFolder, $installedPlugins)) {
            $installedPlugins[] = $pluginFolder;
            $this->updateInstalledPlugins($installedPlugins);

            $this->runPostActivationCommands($pluginFolder);

            Notification::make()
                ->title('Successfully activated '.$pluginFolder.' plugin')
                ->success()
                ->send();
        }

        $this->refreshPlugins();
    }

    public function deactivate(string $pluginFolder): void
    {
        $installedPlugins = $this->getInstalledPlugins();
        $installedPlugins = array_diff($installedPlugins, [$pluginFolder]);
        $this->updateInstalledPlugins($installedPlugins);

        Notification::make()
            ->title('Successfully deactivated '.$pluginFolder.' plugin')
            ->success()
            ->send();

        $this->refreshPlugins();
    }

    public function deletePlugin(string $pluginFolder): void
    {
        $this->deactivate($pluginFolder);

        $pluginPath = resource_path('plugins').'/'.$pluginFolder;

        if (file_exists($pluginPath)) {
            File::deleteDirectory($pluginPath);
        }

        Notification::make()
            ->title('Successfully deleted '.$pluginFolder.' plugin')
            ->success()
            ->send();

        $this->refreshPlugins();
    }

    private function refreshPlugins(): void
    {
        $this->plugins = $this->getPluginsFromFolder();
    }

    /**
     * @return mixed[]
     */
    private function getPluginsFromFolder(): array
    {
        $plugins = [];
        $plugins_folder = resource_path('plugins');

        if (! file_exists($plugins_folder)) {
            mkdir($plugins_folder);
        }

        $scandirectory = scandir($plugins_folder);

        foreach ($scandirectory as $folder) {
            if ($folder === '.' || $folder === '..') {
                continue;
            }

            $studlyFolderName = Str::studly($folder);
            $pluginFile = $plugins_folder.'/'.$folder.'/'.$studlyFolderName.'Plugin.php';

            if (file_exists($pluginFile)) {
                $pluginClass = "Wave\\Plugins\\{$studlyFolderName}\\{$studlyFolderName}Plugin";

                if (class_exists($pluginClass) && method_exists($pluginClass, 'getPluginInfo')) {
                    $plugin = new $pluginClass(app());
                    $info = $plugin->getPluginInfo();
                    $info['folder'] = $folder;
                    $info['active'] = $this->isPluginActive($folder);
                    $plugins[$folder] = $info;
                }
            }
        }

        return $plugins;
    }

    private function isPluginActive(string $folder): bool
    {
        $installedPlugins = $this->getInstalledPlugins();

        return in_array($folder, $installedPlugins);
    }

    private function getInstalledPlugins()
    {
        $path = resource_path('plugins/installed.json');

        return File::exists($path) ? File::json($path) : [];
    }

    private function updateInstalledPlugins($plugins): void
    {
        $json = json_encode($plugins);
        file_put_contents(resource_path('plugins/installed.json'), $json);
    }

    private function runPostActivationCommands(string $pluginFolder): void
    {
        $studlyFolderName = Str::studly($pluginFolder);
        $pluginClass = "Wave\\Plugins\\{$studlyFolderName}\\{$studlyFolderName}Plugin";

        if (class_exists($pluginClass)) {
            $plugin = new $pluginClass(app());

            if (method_exists($plugin, 'getPostActivationCommands')) {
                $commands = $plugin->getPostActivationCommands();

                foreach ($commands as $command) {
                    if (is_string($command)) {
                        Artisan::call($command);
                    } elseif (is_callable($command)) {
                        $command();
                    }
                }
            }

            // Run migrations if they exist
            $migrationPath = resource_path("plugins/{$pluginFolder}/database/migrations");

            if (File::isDirectory($migrationPath)) {
                Artisan::call('migrate', [
                    '--path' => "resources/plugins/{$pluginFolder}/database/migrations",
                    '--force' => true,
                ]);
            }
        }
    }
}
