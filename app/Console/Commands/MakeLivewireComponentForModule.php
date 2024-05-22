<?php

namespace App\Console\Commands;

use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Mhmiton\LaravelModulesLivewire\Commands\LivewireMakeCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MakeLivewireComponentForModule extends LivewireMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modularavel:make-livewire {component} {module} {--view=} {--force} {--inline} {--stub=} {--custom}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle(): void
    {
        parent::handle();

         $runOptimizeClear = $this->askWithCompletion('run php artisan optimize:clear?', [
             'y' => true,
             'n' => false,
         ], 'y,n');

        $runComposerDump = $this->askWithCompletion('run composer dump-autoload?', [
            'y' => true,
            'n' => false,
        ], 'y,n');

        $autoAddRoute = $this->askWithCompletion('add route to routes/livewire.php?', [
            'y' => true,
            'n' => false,
        ], 'y,n');

        if ($autoAddRoute) {
            $this->automaticAddRouteAtRouteFile('livewire');
        }

        if ($runComposerDump) {
            // $this->dump_autoload();
        }

        if ($runOptimizeClear) {
            $this->call('optimize:clear');
        }
    }

    protected function automaticAddRouteAtRouteFile(string $routeGroupPrefix = null): void
    {
        $routesPath = $this->getModulePath().'/routes/livewire.php';
        $marker = "    // auto-routes: auth:module";
        $hasRoute = "Volt::route('login', Login::class)->name('auth::livewire.login');"; // change this, or make it dynamic
        $new_route = "Volt::route('logi2n', Login::class)->name('auth::livewire.login');";
        $routes = file_get_contents($routesPath);

        $routeAlreadyExists = str_contains($new_route, $routes);

        if (!$routeAlreadyExists) {
            $routes = str_replace($hasRoute, $new_route, $routes);
            file_put_contents($routesPath, $routes);
        }
    }


    private function dump_autoload(): void
    {
        $process = new Process(['composer', 'dump-autoload', '-o']);
        $process->setTimeout(null);

        try {
            $process->mustRun();
            $this->info($process->getOutput());
        } catch (ProcessFailedException $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Execute the console command.
     */
    protected function getClassContents(): array|string|null
    {
        $template = file_get_contents($this->component->stub->class);

        if ($this->isInline()) {
            $template = preg_replace('/\[quote\]/', $this->getComponentQuote(), $template);
        }

        return preg_replace(
            pattern: ['/\[namespace\]/', '/\[class\]/', '/\[view\]/', '/\[module_name\]/', '/\[module_lowername\]/', '/\[tag\]/'],
            replacement: [$this->getClassNamespace(), $this->getClassName(), $this->getViewName(), $this->getModuleName(), $this->getModuleLowerName(), $this->getComponentTagForView()],
            subject: $template,
        );
    }

    protected function getViewContents(): array|string|null
    {
        return preg_replace(
            pattern: ['/\[quote\]/', '/\[class\]/', '/\[view\]/', '/\[module_name\]/', '/\[module_lowername\]/', '/\[view_name\]/'],
            replacement: [$this->getComponentQuote(), $this->getClassSourcePath(),$this->getViewSourcePath(), $this->getModuleName(), $this->getModuleLowerName(), ucfirst($this->component->view->name)],
            subject: file_get_contents($this->component->stub->view),
        );
    }

    protected function getComponentQuote(): string
    {
        return "The <code>{$this->getClassName()}</code> livewire component is loaded from the ".($this->isCustomModule() ? 'custom ' : '')."<code>{$this->getModuleName()}</code> module.";
    }

    protected function getComponentTagForView(): string
    {
        $directoryAsView = $this->directories
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $tag = "livewire:{$this->getModuleLowerName()}::{$directoryAsView}";

        return Str::replaceLast('.index', '', $tag);
    }
}
