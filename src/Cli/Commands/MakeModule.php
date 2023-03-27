<?php

namespace Sophy\Cli\Commands;

use Sophy\App;
use Sophy\Cli\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModule extends Command
{

    use Utils;

    protected $templatesDir = '';
    protected $appDir = '';

    protected static $defaultName = "make:module";
    protected static $defaultDescription = "Create a new module";

    protected function configure()
    {
        $this->addArgument("name", InputArgument::REQUIRED, "Module name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument("name");

        $this->templatesDir = App::$root . '/src/resources/templates/';
        $this->appDir = App::$root . '/app/';

        $this->makeActions($name);
        $this->makeEntity($name);
        $this->makeException($name);
        $this->makeRepository($name);
        $this->makeRoute($name);
        $this->makeServices($name);

        $output->writeln("<info>Module created => $name</info>");
        return Command::SUCCESS;
    }

    private function makeActions($name)
    {
        $source = $this->templatesDir . 'ObjectBaseActions';
        $target = $this->appDir . ucfirst($name) . '/Application/Actions';

        $this->rcopy($source, $target);

        $this->replaceFileContent($target . '/Base.php', $name);
        $this->replaceFileContent($target . '/Create.php', $name);
        $this->replaceFileContent($target . '/CreateValidator.php', $name);
        $this->replaceFileContent($target . '/GetAll.php', $name);
        $this->replaceFileContent($target . '/GetByBody.php', $name);
        $this->replaceFileContent($target . '/GetByQuery.php', $name);
        $this->replaceFileContent($target . '/GetOne.php', $name);
        $this->replaceFileContent($target . '/Update.php', $name);
    }

    private function makeEntity($name)
    {

    }

    private function makeException($name)
    {
        $source = $this->templatesDir . 'ObjectbaseException.php';
        $target = $this->appDir . ucfirst($name) . '/Domain/Exceptions/' . ucfirst($name) . 'Exception.php';

        @mkdir($this->appDir . ucfirst($name) . '/Domain');
        @mkdir($this->appDir . ucfirst($name) . '/Domain/Exceptions');
        copy($source, $target);

        $this->replaceFileContent($target, $name);
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

        $this->replaceFileContent($iTarget, $name);
        $this->replaceFileContent($target, $name);
    }

    private function makeRoute($name)
    {
        $source = $this->templatesDir . 'ObjectbaseRoute.php';
        $target = $this->appDir . ucfirst($name) . '/' . ucfirst($name) . 'Routes.php';
        copy($source, $target);

        $this->replaceFileContent($target, $name);
    }

    private function makeServices($name)
    {
        $source = $this->templatesDir . 'ObjectbaseServices';
        $target = $this->appDir . ucfirst($name) . '/Application/Services';

        $this->rcopy($source, $target);

        $this->replaceFileContent($target . '/Base.php', $name);
        $this->replaceFileContent($target . '/CreateService.php', $name);
        $this->replaceFileContent($target . '/FindService.php', $name);
        $this->replaceFileContent($target . '/UpdateService.php', $name);
    }
}