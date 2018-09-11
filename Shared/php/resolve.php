<?php

ini_set('display_errors', 0);

include("dblink.php");

/*
Clear session variable on change of page
*/

if (preg_match('/^[-a-zA-Z0-9_ .]+$/', $_GET['id']) || empty($_GET['id'])) {
    
    $id = $_GET['id'];
} else {
    echo "An error encoutered while processing your request";
    exit;
}


if (preg_match('/^[-a-zA-Z0-9_ .]+$/', $_GET['sub_id']) || empty($_GET['sub_id'])) {
    
    $sub_id = $_GET['sub_id'];
    $sub_id = $_GET['sid'];
} else {
    echo "An error encoutered while processing your request";
    exit;
}
if (preg_match('/^[-a-zA-Z0-9 .]+$/', $_GET['cell']) || empty($_GET['cell'])) {
    
    $cell = $_GET['cell'];
} else {
    echo "An error encoutered while processing your request";
    exit;
}


//$_SESSION['page_id'] = is_numeric($_SESSION['page_id']) ? $_SESSION['page_id'] : 0;

$id = is_numeric($_GET['id']) ? $_GET['id'] : 0;


//$sub_id = is_numeric($_GET['sid']) ? $_GET['sid'] : 0;

$sub_id = ($sub_id == "undefined" || !isset($sub_id)) ? 0 : $sub_id;


if (isset($_SESSION[myPage])) {
    if ($_SESSION[myPage] != $id) { //Clear SearchFilter and FilterArray as user has navigated away from page
        $_SESSION[filterArray]  = '';
        $_SESSION[searchFilter] = '';
    }
}

//Assign SESSION[myPage]
//if($id != 0)
$_SESSION[myPage]    = $id;
$_SESSION['page_id'] = $id;

$current_page = '';
#Set Session value to used to highlight currently selected link on the sidebar links
#$_SESSION[current] = "?id=".$id;
if ($id == '' && $id <> '990' && $id <> '999' && $id <> '991' && $id <> '992') {
    $url                 = str_replace($_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);
    $_SESSION['current'] = getProtocol() . $_SERVER['HTTP_HOST'] . $url;
    $id                  = 0;
    
    
    
} else {
    $_SESSION['current'] = "?id=" . $id;
}
//exit;
switch ($id) {
    case 0:
        echo $current_page = "Shared/php/brokenlink.php";
        break;
    case 1:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "users/list/userList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/userView.php');
        //include('../../administration/php/userForm.php');
        } elseif ($sub_id == '1') {
        include('../../administration/form/userForm.php');
        }*/
        break;
        
    case 2:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/memberList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/memberView.php');
        //include('../../administration/php/userForm.php');
        } /*elseif ($sub_id == '1') {
        include('../../administration/form/memberForm.php');
        }*/elseif ($sub_id == '1') {
            include('../../excelbulk/bulkMembers.php');
        }
        break;   
        
     case 3:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/groupList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/groupView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/groupForm.php');
        }
        break;   
      case 4:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/groupList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/groupView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/groupForm.php');
        }*/
        break;   
        
      case 4:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/groupList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/groupView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/groupForm.php');
        }*/
        break;   
        
           case 21:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/visitorList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/visitorView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/visitorForm.php');
        }*/
        break; 
        
     case 23:
        $current_page = "administration/list/groupTypes.php";
        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/groupTypeView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/groupTypeForm.php');
        }
        break;

     case 69:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/dedicationList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/dedicationView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/dedicationForm.php');
        }*/
        break; 
        
                     case 31:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/baptismList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/baptismView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/baptismForm.php');
        }*/
        break; 
        
        case 20:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "administration/list/eventList.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        /*elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../administration/view/eventView.php');
      
        } elseif ($sub_id == '1') {
        include('../../administration/form/eventForm.php');
        }*/
        break; 
        
        
          case 116:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "finance/list/chartOfAccounts.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../finance/view/chartOfAccountsView.php');
      
        } elseif ($sub_id == '1') {
        include('../../finance/form/chartOfAccountsForm.php');
        }
        break; 
        
        case 117:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "finance/list/transactionTypes.php";
        //$current_page = "onboarding/php/tables.html";
        
        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
        include('../../finance/view/transactionTypesView.php');
      
        } elseif ($sub_id == '1') {
        include('../../finance/form/transactionTypesForm.php');
        }
        break;


    case 119:
        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "finance/list/transactionList.php";
        //$current_page = "onboarding/php/tables.html";

        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
            include('../../finance/view/transactionListView.php');

        } /*elseif ($sub_id == '1') {
            include('../../finance/form/moneyin.php');
        }*/elseif ($sub_id == '1') {
            include('../../excelbulk/bulkIncome.php');
        }
        break;

    case 118:

        // $current_page = "onboarding/list/userList.php"; //Grid loading page
        $current_page = "finance/list/transactionList.php";
        //$current_page = "onboarding/php/tables.html";

        if ($sub_id == '0') {
            echo $current_page;
        }
        elseif ($sub_id == 'view') {    //Inner loading pages
            include('../../finance/view/transactionListView.php');

        } /*elseif ($sub_id == '1') {
            include('../../finance/form/moneyout.php');
        }*/elseif ($sub_id == '1') {
            include('../../excelbulk/bulkExpense.php');
        }
        break;



    default:
        echo $current_page = "Shared/php/brokenlink.php";
        break;
}
$_SESSION['current_page'] = $current_page;
?>
