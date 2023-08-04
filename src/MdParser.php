<?php

namespace SimplyDi\SimplyMarkdown;

use League\CommonMark\Exception\CommonMarkException;
use Nette\Utils\FileSystem as FS;
use Nette\Utils\Finder;

/**
 *
 */
class MdParser
{

    /**
     * @param CommonMark $commonMark
     */
    public function __construct(
        protected string $path,
        protected CommonMark $commonMark
    )
    {
    }

    /**
     * @param string $fileLocation
     * @param string|null $locale
     * @return array
     * @throws CommonMarkException
     */
    public function getFileContent(string $fileLocation, array $replaceArr = []): ?array
    {

        $file = $this->path . $fileLocation . '.md';

        if (!file_exists($file)) {
            $file = $this->path . $fileLocation . '/index.md';

            if (!file_exists($file)) {
                return null;
            }
        }

        $file = FS::read($file);

        $file = $this->commonMark->convertToHtml($file);

        if (isset($file['meta']['published']) && $file['meta']['published'] === false) {
            return null;
        }

        if (!empty($replaceArr))
        {
            foreach ($replaceArr as $itemToReplace => $replaceWith)
            {
                $file = str_replace($itemToReplace, $replaceWith, $file);
            }
        }

        return $file;
    }

    /**
     * @param string $folderLocation
     * @return array|null
     * @throws CommonMarkException
     */
    public function getFolderFiles(string $folderLocation): ?array
    {
        $folder = $this->path . $folderLocation;

        if (!file_exists($folder)) {
            return null;
        }

        $files = Finder::findFiles('*.md')->in($folder);

        $filesArray = [];
        // foreach
        foreach ($files as $file) {
            $file = FS::read($file);
            $file = $this->commonMark->convertToHtml($file);

            $filesArray[] = $file;
        }

        return $filesArray;
    }

}
