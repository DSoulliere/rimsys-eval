<?php

namespace App\Models;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class Document extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'disk',
        'filepath',
        'mimetype',
        'filesize'
    ];

    /**
     * Returns all of the users that own the document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    /**
     * Static method to create a model from the received file
     *
     * @param mixed $file
     * @param array $attributes
     * @param string|null $dest
     * @param string $disk
     * @return mixed
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    static public function createFromFile($file, array $attributes, string $dest = 'files', string $disk = 'default')
    {
        $disk = config("filesystems.$disk");
        $dest = $dest;

        $filesize = filesize($file);
        $mimetype = $file->getMimeType();
        $filepath = Storage::disk($disk)->put($dest, $file);

        return self::create(array_merge($attributes, compact('disk', 'filesize', 'filepath', 'mimetype')));
    }


    /**
     * Takes a file and updates the model to new parameters
     *
     * @param mixed $file
     * @param array $attributes
     * @param string|null $dest
     * @return bool
     * @throws MassAssignmentException
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    public function updateFromFile($file, array $attributes, string $dest = null)
    {
        $dest = $dest;

        $storage = Storage::disk($this->disk);
        $storage->delete($this->filepath);

        $filesize = filesize($file);
        $mimetype = $file->getMimeType();
        $filepath = $storage->put($dest, $file);

        $this->fill(array_merge($attributes, compact('filesize', 'filepath', 'mimetype')));

        return $this->save();
    }

}
