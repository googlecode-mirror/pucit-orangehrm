<?php
/*
// OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
// all the essential functionalities required for any enterprise.
// Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com

// OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
// the GNU General Public License as published by the Free Software Foundation; either
// version 2 of the License, or (at your option) any later version.

// OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
// without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU General Public License for more details.

// You should have received a copy of the GNU General Public License along with this program;
// if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
// Boston, MA  02110-1301, USA
*/

require_once ROOT_PATH . '/lib/models/maintenance/Rights.php';

class EXTRACTOR_Rights {

    function EXTRACTOR_Rights() {

        $this->urights = new Rights();
    }

    function parseData($postArr) {
        $this->urights->setUserGroupID(trim($postArr['txtUserGroupID']));
        $array = array();
        if(isset($postArr['Module'])) {
            $this->urights->setModuleID(trim($postArr['Module']));
            $array[0] = $this->urights->getModuleID();
        }
        else {
            $categories = array();
            for($i=1, $j=1; $i<=$postArr['categoryCount']; $i++) {
                if(isset($postArr['chkcategory'.$i])) {
                    $categories[$j] = $postArr['chkcategory'.$i];
                    $j++;
                }
            }
            $k=0;
            $category = array();
            $counts = array();
            $counts = explode("-", $postArr['subCategoryCount']);
            for($i=1, $ascii1=97; $i<=count($categories); $i++, $ascii1++) {
                $category = $categories[$i];
                if(count($category) != $counts[$i-1]) {
                    $flag=0;
                }
                else {
                    $flag=1;
                }

                if($flag == 1) {
                    $array[$k] = $postArr['Module'].chr($ascii1);
                    $k++;
                }
                else if($flag == 0) {
                        for($c=0; $c<count($category); $c++) {
                            $array[$k] = $category[$c];
                            $k++;
                        }
                }
            }
        }
        $this->urights->setModuleCategoryID($array);
        $newArray = array();
        $newArray = $this->urights->getModuleCategoryID();
        $this->urights->setRightAdd(isset($postArr['chkAdd']) ? 1 : 0 );
        $this->urights->setRightEdit(isset($postArr['chkEdit']) ? 1 : 0 );
        $this->urights->setRightDelete(isset($postArr['chkDelete']) ? 1 : 0 );
        $this->urights->setRightView(isset($postArr['chkView']) ? 1 : 0 );
        return $this->urights;
    }
}
?>