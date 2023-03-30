<?php

namespace Sophy\Cli\Commands;

use Sophy\App;
use Sophy\Database\DB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModule extends Command
{

    protected $templatesDir = '';
    protected $appDir = '';
    protected $infoTable = [];
    protected $output = null;

    protected static $defaultName = "make:module";
    protected static $defaultDescription = "Create a new module";

    protected function configure()
    {
        $this->addArgument("name", InputArgument::REQUIRED, "Module name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = new ConsoleOutput();
        $name = $input->getArgument("name");

        $this->templatesDir = resourcesDirectory(). '/templates/';
        $this->appDir = App::$root . '/app/';

        $moduleIsValid = $this->validateHasTable($name);

        if ($moduleIsValid) {
            $this->makeActions($name);
            $this->makeEntity($name);
            $this->makeDTO($name);
            $this->makeException($name);
            $this->makeRepository($name);
            $this->makeRoute($name);
            $this->makeServices($name);

            $output->writeln("<info>Module created => $name</info>");

            return Command::SUCCESS;

        }

        return Command::FAILURE;
    }

    private function validateHasTable($name)
    {
        try {
            $query = DB::query('describe ' . $name);
            $dataTable = $query->fetchAll();

            foreach ($dataTable as $index => $value) {
                $data = new \stdClass();
                $data->key = $value['Field'];
                $data->data = $value;
                $this->infoTable[$index] = $data;
            }
            return true;

        } catch (\Exception $exception) {
            $this->output->writeln('<error>' . $exception->getMessage() . '</error>');
            return false;
        }

    }

    private function makeActions($name)
    {
        $source = $this->templatesDir . 'ObjectBaseActions';
        $target = $this->appDir . ucfirst($name) . '/Application/Actions';

        recursiveCopy($source, $target);

        replaceFileContent($target . '/Base.php', $name);
        replaceFileContent($target . '/Create.php', $name);
        replaceFileContent($target . '/CreateValidator.php', $name);
        replaceFileContent($target . '/GetAll.php', $name);
        replaceFileContent($target . '/GetByBody.php', $name);
        replaceFileContent($target . '/GetByQuery.php', $name);
        replaceFileContent($target . '/GetOne.php', $name);
        replaceFileContent($target . '/Update.php', $name);
    }

    private function makeEntity($name)
    {
        $__srcEntity = PHP_EOL;
        $__srcEntity .= PHP_EOL;
        $__srcEntity .= "namespace App\\" . ucfirst($name) . "\Domain\Entities;" . PHP_EOL;
        $__srcEntity .= PHP_EOL;
        $__srcEntity .= "use Sophy\Domain\BaseEntity;" . PHP_EOL;
        $__srcEntity .= PHP_EOL;
        $__srcEntity .= "final class " . ucfirst($name) . " extends BaseEntity" . PHP_EOL;
        $__srcEntity .= "{" . PHP_EOL;
        $__srcEntity .= PHP_EOL;
        $__srcEntity .= "    protected \$fillable = [" . PHP_EOL;
        foreach ($this->infoTable as $indexField => $field) {
            $__srcEntity .= "        '" . $this->infoTable[$indexField]->key . "'," . PHP_EOL;
        }
        $__srcEntity .= "    ];" . PHP_EOL;

        $__srcEntity .= PHP_EOL;

        foreach ($this->infoTable as $indexField => $field) {
            $field = $this->infoTable[$indexField]->key;
            $__srcEntity .= "    public function set" . ucwords($field) . "($" . $field . "){ " . PHP_EOL;
            $__srcEntity .= "        \$this->setAttribute('" . $field . "', \$" . $field . ");" . PHP_EOL;
            $__srcEntity .= "    }" . PHP_EOL;
            $__srcEntity .= PHP_EOL;

            $__srcEntity .= "    public function get" . ucwords($field) . "(){ " . PHP_EOL;
            $__srcEntity .= "        return \$this->getAttribute('" . $field . "');" . PHP_EOL;
            $__srcEntity .= "    }" . PHP_EOL;
            $__srcEntity .= PHP_EOL;

        }
        $__srcEntity .= "}" . PHP_EOL;

        $__srcEntity = "<?php " . $__srcEntity . "?>";

        $dir = $this->appDir . ucfirst($name) . '/Domain/Entities';

        @mkdir($dir, 0777, true);

        writeFile($__srcEntity, $dir . '/' . ucfirst($name) . ".php");
    }

    private function makeDTO($name)
    {
        $__srcEntity = PHP_EOL;
        $__srcEntity .= PHP_EOL;
        $__srcEntity .= "namespace App\\" . ucfirst($name) . "\Application\DTO;" . PHP_EOL;
        $__srcEntity .= PHP_EOL;
        $__srcEntity .= "final class " . ucfirst($name) . "DTO" . PHP_EOL;
        $__srcEntity .= "{" . PHP_EOL;
        foreach ($this->infoTable as $indexField => $field) {
            $__srcEntity .= "    public $" . $this->infoTable[$indexField]->key . ";" . PHP_EOL;
        }

        $__srcEntity .= "}" . PHP_EOL;

        $__srcEntity = "<?php " . $__srcEntity . "?>";

        $dir = $this->appDir . ucfirst($name) . '/Application/DTO';

        @mkdir($dir, 0777, true);

        writeFile($__srcEntity, $dir . '/' . ucfirst($name) . "DTO.php");
    }

    private function makeException($name)
    {
        $source = $this->templatesDir . 'ObjectbaseException.php';
        $target = $this->appDir . ucfirst($name) . '/Domain/Exceptions/' . ucfirst($name) . 'Exception.php';

        @mkdir($this->appDir . ucfirst($name) . '/Domain');
        @mkdir($this->appDir . ucfirst($name) . '/Domain/Exceptions');
        copy($source, $target);

        replaceFileContent($target, $name);
    }

    private function makeRepository($name)
    {
        $iSource = $this->templatesDir . 'IObjectbaseRepository.php';
        $source = $this->templatesDir . 'ObjectbaseRepository.php';

        @mkdir($this->appDir . ucfirst($name) . '/Infrastructure');
        $iTarget = $this->appDir . ucfirst($name) . '/Domain/I' . ucfirst($name) . 'Repository.php';
        $target = $this->appDir . ucfirst($name) . '/Infrastructure/' . ucfirst($name) . 'RepositoryMysql.php';
        copy($iSource, $iTarget);
        copy($source, $target);

        replaceFileContent($iTarget, $name);
        replaceFileContent($target, $name);
    }

    private function makeRoute($name)
    {
        $source = $this->templatesDir . 'ObjectbaseRoute.php';
        $target = $this->appDir . ucfirst($name) . '/' . ucfirst($name) . 'Routes.php';
        copy($source, $target);

        replaceFileContent($target, $name);
    }

    private function makeServices($name)
    {
        $source = $this->templatesDir . 'ObjectbaseServices';
        $target = $this->appDir . ucfirst($name) . '/Application/Services';

        recursiveCopy($source, $target);

        replaceFileContent($target . '/Base.php', $name);
        replaceFileContent($target . '/CreateService.php', $name);
        replaceFileContent($target . '/FindService.php', $name);
        replaceFileContent($target . '/UpdateService.php', $name);
    }
}