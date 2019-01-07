<!-- sidebar: style can be found in sidebar.less -->
<aside class="main-sidebar" id="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <input type="hidden" id="dynamicWrapperIdentifier" value=""/>
        </div>

        <?php

        GLOBAL $dblink;

        $_SESSION['menutab'] = $item;
        $count = 0;
        $menu_bar = '<ul class="sidebar-menu">
            <li class="header">' . strtoupper($item) . '</li> ';
        $strQuery = "SELECT MENU_NAME,URL,PRMS_ID,ICON_TAG FROM SRC_prmssns P WHERE PRMS_ID IN (SELECT SRC_rolepermissions.PermissionID FROM SRC_rolepermissions WHERE SRC_rolepermissions.RoleID IN (SELECT ROLEID FROM SRC_userroles WHERE SRC_userroles.UserID = " . $_SESSION['user_id'] . ")) AND MENU_LEVEL = 1 AND IS_MENU = 1 AND MODULE = '$item' ORDER BY MENU_POS ASC";

        //$res = oci_parse($dblink, $strQuery);
        // oci_execute($res);
        //$resultArray = getResultArray($res);
        $resultArray = execQuery($strQuery);
        //echo count($resultArray) ;
        if (count($resultArray) > 0) {
            foreach ($resultArray as $row) {
                $menu_name = $row["MENU_NAME"];
                $menu_icon = $row["ICON_TAG"];
                //$menu_icon=isset($row["ICON_TAG"])? $menu_icon : '<i class="fa fa-th"></i>';

                $modulelevel2 = $menu_name;

                $approvalLevels = 0;
                $bankapproval = 0;

                // echo $menu_name;

                if (strtoupper($item) == "APPROVALS") {
                    $approval_title = strtoupper($menu_name);
                    // $approval_title = strtoupper(substr($menu_name, 0, -1)." Creation");
                    $approvalsQuery = "select nvl(levels,0) from nic_approval_config where upper(approvals_menu_name)= '$approval_title' ";
                    $bankapprovalsQuery = "select bank_approval from nic_approval_config where upper(approvals_menu_name)= '$approval_title' ";
                    $approvalLevels = execQuery($approvalsQuery, true);
                    $bankapproval = execQuery($bankapprovalsQuery, true);
                    $approvalLevels = $approvalLevels + $bankapproval;
                    //echo " select bank_approval from nic_approval_config where upper(process)= '$approval_title' ";

                }

                $active = $count == 0 ? 'class="active treeview"' : '';
                echo $children = execQuery("select count(*) from SRC_prmssns where child_of ='$row[PRMS_ID]' ", true);

                if ($children == 0 || (strtoupper($item) == "APPROVALS" && $approvalLevels == 0)) {

                    if (strtoupper($item) == "APPROVALS") {
                    } else
                        $menu_bar .= '<li ' . $active . ' ><a href="' . $row["URL"] . '#" class="loaddata"  >
 ' . $menu_icon . ' <span>' . ' ' . $menu_name . '</span> </i></a>';
                } else {
                    $menu_bar .= '<li ' . $active . '><a href="' . $row["URL"] . '#">' . $menu_icon . '</i><span class="fa arrow">' . ' ' . $menu_name . '</span><i class="fa fa-angle-left pull-right"></i></a>';
                    // $menu_bar.= ' <ul class="treeview-menu">';
                }


                // echo $approval_title;

                $strQuery = "SELECT MODULE, MENU_NAME,URL,PRMS_ID,ICON_TAG FROM SRC_prmssns WHERE PRMS_ID IN 
(SELECT PERMISSIONID FROM SRC_rolepermissions WHERE ROLEID IN 
(SELECT ROLEID FROM SRC_userroles WHERE USERID =  " . $_SESSION['user_id'] . ")) AND MENU_LEVEL = 2 AND IS_MENU = 1 AND MODULE = '$item' AND CHILD_OF = '" . $row["PRMS_ID"] . "' ORDER BY MENU_POS ASC";

                //$res2 = oci_parse($dblink, $strQuery);
                //    oci_execute($res2);
                //   $resultArray2 = getResultArray($res2);
                $resultArray2 = execQuery($strQuery);
                $parent_menu = $menu_name;
                $thisSize = count($resultArray2);
                if ($thisSize > 0) {

                    $menu_bar .= ' <ul class="treeview-menu">';

                    $intCount = 0;

                    foreach ($resultArray2 as $row2) {
                        $modulelevel3 = $row2["MENU_NAME"];
                        $menu_icon = $row2["ICON_TAG"];
                        //$menu_bar .= "<li><a href='" . $row2["URL"] . "' class=''>" . $row2["MENU_NAME"] . "</a></li>";

                        // echo $intCount."".$approvalLevels;
                        //   if($intCount == $approvalLevels $$ $approvalLevels !=0)

                        //  echo $parent_menu."COUNT: ".$intCount;

                        if ($approvalLevels > 0) {
                            if ($intCount >= $approvalLevels && $intCount < 5) {
                                $intCount++;
                                continue;
                            } else {
                                if ($intCount < 5) {
                                    $menu_bar .= '<li><a href="' . $row2["URL"] . '#" class="loaddata" >' . $menu_icon . $row2["MENU_NAME"] . '</a></li>';
                                } else {
                                    if ($bankapproval > ($intCount - 5))
                                        $menu_bar .= '<li><a href="' . $row2["URL"] . '#" class="loaddata" >' . $menu_icon . $row2["MENU_NAME"] . '</a></li>';

                                }

                                $intCount++;
                            }
                        } else {
                            $menu_bar .= '<li><a href="' . $row2["URL"] . '#" class="loaddata" >' . $menu_icon . $row2["MENU_NAME"] . '</a></li>';

                        }
                        // $row2 = end($resultArray2);
                        /*    if($bankapproval >= 1)
                              $menu_bar .= $intCount.'<li><a href="' . $row2["URL"] . '#" class="loaddata" ><i class="fa fa-circle-o"></i> '. $row2["MENU_NAME"] .'</a></li>';
                             // break;

                          */


                    }


                    $menu_bar .= "</ul>";//close third level
                }
                $menu_bar .= "</li>";
                $count++;
            }
            echo $menu_bar;
        }


        ?>

        <!-- sidebar menu: : style can be found in sidebar.less -->


        </ul>
    </section>
</aside>

       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       