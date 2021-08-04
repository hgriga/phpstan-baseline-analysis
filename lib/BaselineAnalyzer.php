<?php

namespace staabm\PHPStanBaselineAnalysis;

final class BaselineAnalyzer {
    private $baseline;

    public function __construct(Baseline $baseline) {
        $this->baseline = $baseline;
    }

    public function analyze():AnalyzerResult {
        $result = new AnalyzerResult();

        foreach($this->baseline->getIgnoreErrors() as $errorMessage) {
            if (!str_contains($errorMessage, 'cognitive complexity')) {
                continue;
            }

            preg_match('/Class cognitive complexity is (?P<value>\d+), keep it under (?P<limit>\d+)/', $errorMessage, $matches);
            if ($matches) {
                $result->overallComplexity += $matches['value'];
            }
        }

        return $result;
    }
}