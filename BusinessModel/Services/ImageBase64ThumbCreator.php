<?php

namespace HabanaTech\BusinessModel\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageBase64ThumbCreator extends AbstractController
{
    private $base64data;

    /**
     * ImageBase64ThumbCreator constructor.
     * @param string $path
     * @param bool $absoluteFileName
     */
    public function __construct(string $path = 'folder', $absoluteFileName = false)
    {
        if ($absoluteFileName) {
            $path = $this::getStaticRelativePath($path);
            $path = __DIR__ . '/../../public/' . $path;
        }

        if (file_exists($path)) {
            if (($image = @imagecreatefromjpeg($path)) || ($image = @imagecreatefrompng($path))) {
                $width = imagesx($image) ?? 1;
                $height = imagesy($image) ?? 1;
                $original_aspect = $height / $width;

                $thumb_width = 15; //px

                $thumb_height = $original_aspect * $thumb_width;

                $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

                imagecopyresampled(
                    $thumb,
                    $image,
                    0,
                    0,
                    0,
                    0,
                    $thumb_width,
                    $thumb_height,
                    $width,
                    $height
                );

                imageinterlace($thumb, true);
                ob_start();

                imagejpeg($thumb);
                $image_data = ob_get_clean();

                $this->base64data = 'data:image/jpeg;base64,' . base64_encode($image_data);
            }
        }
    }

    /**
     * @return string
     */
    public function getBase64data(): ?string
    {
        return $this->base64data;
    }

    public static function getStaticRelativePath($path)
    {
        $temp = explode('/static/', $path);
        if (count($temp)) {
            $path = $temp[count($temp) - 1];
        }
        if (!preg_match('|^static/|', $path)) {
            $path = '/static/' . $path;
        }

//        return trim($path,'/\\');
        return $path;
    }
}
