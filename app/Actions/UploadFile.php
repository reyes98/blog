<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadFile
{
    private $file;
    private $uploadPath;
    private $options;
    
    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile(?UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Set the value of uploadPath
     *
     * @return  self
     */ 
    public function setUploadPath(String $uploadPath)
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }

    /**
     * Set the value of options
     *
     * @return  self
     */ 
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function execute(): ?string 
    {
        if (!$this->file) {
            return null;
        }
        $fileName = (string) Str::of($this->file
                ->getClientOriginalName())
                ->beforeLast('.')
                ->slug()
                ->append('.')
                ->append($this->file->getClientOriginalExtension());

        if ($this->options) {
            $this->file->storeAs($this->uploadPath, $fileName, 'public');
        }else{
            $this->file->storeAs($this->uploadPath, $fileName);
        }

        return $fileName;
    }

    

    
}
