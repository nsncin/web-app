<?php
namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    public function index()
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = "SELECT 
                u.userId as EmployeeUserId,
                u.first_name as EmployeeFirstName,
                u.last_name as EmployeeLastName ,
                de.depId as DepId,

                d.dept_name as DepartmentName 
              --  dm.userId as DeptManagerId 
               

          FROM  users u
                INNER JOIN dept_emp de ON u.userId=de.userId 
                iNNER JOIN departments d on d.dept_no = de.depId
               -- JOIN dept_manager dm on de.depId=dm.dept_no 
         

                ORDER BY u.userId ASC LIMIT 50
                   
              ";





        $sql2="SELECT 
            us.userId as EmployeeUserId2,
            us.first_name as EmployeeFirstName2,
            us.last_name as EmployeeLastName2
         

            FROM users us
            JOIN dept_manager dm ON us.userId=dm.userId 
            LIMIT 1
        ";

        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        //$stmt2 = $conn->prepare($sql);
        //$stmt2->execute();


        // returns an array of arrays (i.e. a raw data set)
        $results=$stmt->fetchAll();

      
    //var_dump($results);
   
     
   // die();
      

    
       $data['usersAll']=$results;


        return $this->render(
            'index.html.twig',$data
        );
    }
}