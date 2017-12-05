<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Policy\PropertiesPhotosPolicy;

/**
 * PropertiesPhotos Controller
 *
 * @property \App\Model\Table\PropertiesPhotosTable $PropertiesPhotos
 */
class PropertiesPhotosController extends AppController
{
    function isAuthorized($user)
    {
//        $element = $this->Prosecutors->findById($this->request->getParam('pass.0'))
//            ->first();

        return PropertiesPhotosPolicy::isAuthorized($this->request->action, $user);
    }

    public function add()
    {
        $maxPhotos = $this->PropertiesPhotos->find()
            ->select(['max_ordem' => 'MAX(ordem)'])
            ->where(['property_id' => $this->request->getData('property_id')])
            ->first();

        $photo = $this->PropertiesPhotos->newEntity();

        $newName = time();

        $photo['url'] = $newName . '.jpg';
        $photo['ordem'] = $maxPhotos['max_ordem'] + 1;
        $photo['property_id'] = $this->request->getData('property_id');

        if ($this->PropertiesPhotos->save($photo)) {
            $uploadsDir = WWW_ROOT . "/file";

            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir);
            }

            $filePath = sprintf('/properties/%s/', $this->request->getData('property_id'));

            $buffer = explode('/', $filePath);
            $incrementalPath = $uploadsDir;
            foreach ($buffer as $b) {
                $incrementalPath .= '/' . $b;

                if (!is_dir($incrementalPath)) {
                    mkdir($incrementalPath);
                }
            }

            $newFileName = sprintf('%s/%s.jpg', $incrementalPath, $newName);

            $image = null;
            switch ($this->request->getData('file')["type"]) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($this->request->getData('file')["tmp_name"]);

                    break;

                case 'image/png':
                    $image = imagecreatefrompng($this->request->getData('file')["tmp_name"]);

                    break;
            }

            if (file_exists(WWW_ROOT . '/file/logo.png')) {
                $stamp = imagecreatefrompng(WWW_ROOT . '/file/logo.png');
            } else {
                $stamp = imagecreatefrompng(WWW_ROOT . '/img/new_logo_kdym.png');
            }

            $margin = 10;

            $stampWidth = imagesx($image) * 0.1;
            $stampHeight = imagesy($image) * 0.1;

            $positions = [
                [$margin, $margin],
                [imagesx($image) - $stampWidth - $margin, $margin],
                [imagesx($image) - $stampWidth - $margin, imagesy($image) - $stampHeight - $margin],
                [$margin, imagesy($image) - $stampHeight - $margin],
            ];

            $position = array_rand($positions);

            imagecopyresized($image, $stamp, $positions[$position][0], $positions[$position][1], 0, 0, $stampWidth, $stampHeight, imagesx($stamp), imagesy($stamp));

            imagedestroy($stamp);

            imagejpeg($image, $newFileName);

            imagedestroy($image);
        }

        $this->autoRender = false;
    }

    public function fetch($propertyId)
    {
        $this->autoRender = false;
        $this->response->type('json');

        $photos = $this->PropertiesPhotos->find()
            ->where(['property_id' => $propertyId])
            ->order('ordem');

        $this->response->body(json_encode($photos));
    }

    public function updateOrder()
    {
        $this->autoRender = false;

        $buffer = explode('&', $this->request->getData('images'));

        foreach ($buffer as $order => $b) {
            $buffer2 = explode('=', $b);

            $photo = $this->PropertiesPhotos->get($buffer2[1]);

            $photo['ordem'] = $order;

            $this->PropertiesPhotos->save($photo);
        }
    }

    public function delete()
    {
        $this->autoRender = false;

        $ids = explode(',', $this->request->getData('ids'));

        foreach ($ids as $id) {
            $photo = $this->PropertiesPhotos->get($id);

            if ($this->PropertiesPhotos->delete($photo)) {
                unlink(sprintf('%s/file/properties/%s/%s', WWW_ROOT, $photo['property_id'], $photo['url']));
            }
        }
    }
}