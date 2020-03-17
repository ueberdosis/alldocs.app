<?php

namespace Ueberdosis\Pandoc;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Pandoc
{
    protected $file;

    protected $from;

    protected $to;

    protected $output;

    public function file($value)
    {
        $this->file = $value;

        return $this;
    }

    public function from($value)
    {
        $this->from = $value;

        return $this;
    }

    public function to($value)
    {
        $this->to = $value;

        return $this;
    }

    public function output($value)
    {
        $this->output = $value;

        return $this;
    }

    public function convert()
    {
        // Example: pandoc test1.md -f markdown -t html -s -o test1.html
        $command = sprintf("pandoc %s -f %s -t %s -s -o %s", $this->file, $this->from, $this->to, $this->output);

        // exec(escapeshellcmd($command), $cmdOutput);

        // return $cmdOutput;

        $process = new Process([
            'pandoc', $this->file,
            "-f", "{$this->from}",
            "-t", "{$this->to}",
            "-s",
            "-o", "{$this->output}",
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function version()
    {
        $process = new Process([
            'pandoc',
            '-v',
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
