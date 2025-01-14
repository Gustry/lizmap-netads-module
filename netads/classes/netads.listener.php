<?php

/**
 * @author    3liz
 * @copyright 2021 3liz
 *
 * @see      https://3liz.com
 *
 * @license    Mozilla Public Licence
 */
class netadsListener extends jEventListener {
    public function ongetMapAdditions($event) {
        $repository = $event->repository;
        $project = $event->project;

        $layerParcelle = 'parcelles';

        $projectNetADSCheck = \netADS\Util::projectIsNetADS($repository, $project);
        switch ($projectNetADSCheck) {
            case \netADS\Util::PROJECT_OK:
                $jscode = array('const netAdsConfig  = {"layerParcelle" : "' . $layerParcelle . '" , ' .
                    ' "parcelleQueryUrl":"' . jUrl::get('netads~dossiers:index') . '"};');

                break;
            case \netADS\Util::ERR_CODE_PROJECT_NAME:
                $jscode = array('console.warn(`Le projet doit se nommer "netads".`);');

                break;
            case \netADS\Util::ERR_CODE_PROJECT_VARIABLE:
                $jscode = array('console.warn(`La variable "netads_idclient" doit être définie dans votre projet QGIS.`);');

                break;
        }

        $js = array(jUrl::get('jelix~www:getfile', array('targetmodule' => 'netads', 'file' => 'netads.js')));

        $event->add(
            array(
                'js' => $js,
                'jscode' => $jscode,
            )
        );
    }
}
