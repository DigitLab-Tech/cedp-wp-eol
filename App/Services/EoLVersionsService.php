<?php

namespace CEDP\WPEOL\App\Services;

use CEDP\WPEOL\App\EndOfLifeApi;

class EoLVersionsService
{
    private ?array $eolData;

    public function __construct()
    {
        $this->eolData = json_decode(EndOfLifeApi::GetCached(), true);
    }

    public function getLatest(){
        return $this->eolData[0]['latest'];
    }

    public function getSubversions(string $cycle): array{
        $latest = $cycle;
        $record = self::getRecord($cycle);
        $latest = $record['latest'];

        if($cycle === $latest){
            return [$latest];
        }

        $subversions = [];
        $latestSplit = explode('.', $latest);
        $subversionEnd = intval(array_pop($latestSplit));
        $subversionBegin = implode('.', $latestSplit).'.';

        for($i = $subversionEnd; $i > 0; $i--){
            $subversions[] = $subversionBegin.$i;
        }

        $subversions[] = $cycle;
        return $subversions;
    }

    public function getVersionStatus(string $version): string{
        $latest = $this->eolData[0]['latest'];

        if($version === $latest){
            return 'latest';
        }

        $record = $this->getRecord(self::ExtractCycle($version));

        if($record['eol'] !== false){
            return 'insecure';
        }

        return 'outdated';
    }

    public function validateVersion(string $version): bool{
        if(!preg_match('/^[\d\.\W]+$/', $version)){
            return false;
        }

        if($this->getRecord($this->extractCycle($version)) === null){
            return false;
        }

        return true;
    }

    public function isDataValid(): bool{
        return $this->eolData !== null;
    }

    private function extractCycle(string $version): string{
        if(strlen($version) === 3){
            return $version;
        }

        return substr($version, 0, 3);
    }

    private function getRecord(string $cycle): ?array{
        foreach($this->eolData as $record){
            if($record['cycle'] === $cycle){
                return $record;
            }
        }
        return null;
    }
}