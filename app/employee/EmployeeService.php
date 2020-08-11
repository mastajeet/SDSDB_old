<?php


class EmployeeService
{
    private $current_session;

    function __construct($current_session)
    {
        $this->current_session = $current_session;
    }

    function getEmployeSelectList($company, $datetime=null)
    {
        if(is_null($datetime)){
            $employee_list_query = $this->getAllEmployeWithHighestQualificationDataFromDBQuery();
        }else{
            $employee_list_query = $this->getWorkableEmployeWithHighestQualificationDataFromDBQuery($datetime);
        }
        $employe_list = $this->buildEmployeeList($employee_list_query);

        return($employe_list);
    }

    public function getViewEmployeeURI($IDEmploye){
        return 'index.php?Section=Employe&IDEmploye='.$IDEmploye;
    }
    //    public function getViewEmployeeURI($IDEmploye){
//        return 'api_de_yann.com/employe/<IDEmploye>
//    }



    private function getWorkableEmployeWithHighestQualificationDataFromDBQuery($shift_datetime)
    {
        # qualification id : 2=cbro,3=sn,10=caisser
        # 10 caissier a été ajouté pour TR

        $timetime = $shift_datetime->getTimestamp();
        $query = "SELECT employe.IDEmploye,employe.Nom, employe.Prenom, qualification.Qualification FROM employe
            JOIN (select IDEmploye, Max(IDQualification) as max_qualif from link_employe_qualification WHERE UNIX_TIMESTAMP(NOW()) < link_employe_qualification.Expiration and link_employe_qualification.IDQualification IN (2,3,10) GROUP BY IDEmploye) maximum_effective_qualification 
                on employe.IDEmploye = maximum_effective_qualification.IDEmploye 
            JOIN qualification 
                on qualification.IDQualification = maximum_effective_qualification.max_qualif 
        WHERE !Cessation AND employe.IDEmploye NOT IN(SELECT vacances.IDEmploye FROM vacances WHERE DebutVacances <=".$timetime." and FinVacances >= ".$timetime.")
         ORDER BY Nom ASC, Prenom ASC";

        return($query);
    }

    private function getAllEmployeWithHighestQualificationDataFromDBQuery()
    {
        $query = "SELECT employe.IDEmploye,employe.Nom, employe.Prenom, qualification.Qualification 
        FROM employe 
            JOIN (select IDEmploye, Max(IDQualification) as max_qualif from link_employe_qualification WHERE UNIX_TIMESTAMP(NOW()) < link_employe_qualification.Expiration and link_employe_qualification.IDQualification IN (2,3,10) GROUP BY IDEmploye) maximum_effective_qualification 
                on employe.IDEmploye = maximum_effective_qualification.IDEmploye 
            JOIN qualification 
                on qualification.IDQualification = maximum_effective_qualification.max_qualif 
        WHERE !Cessation  
        ORDER BY Nom ASC, Prenom ASC";

        return($query);
    }

    private function buildEmployeeList($query){
        $sql_class = new SqlClass();
        $sql_class->Select($query);
        $employee_list = [];

        while($cursor = $sql_class->FetchAssoc()){
            $employee_list[$cursor['IDEmploye']] = $cursor['Nom']." ".$cursor['Prenom']. " [".$cursor['Qualification']."]" ;
        }

        return $employee_list;
    }
}