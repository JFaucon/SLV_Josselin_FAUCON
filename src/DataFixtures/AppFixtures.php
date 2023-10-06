<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Customer;
use App\Entity\Model;
use App\Entity\Option;
use App\Entity\Reservation;
use App\Entity\State;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Vehicle;
use Cassandra\Date;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $entityManager): void
    {

        $types = ['SUV', 'Berline', 'Cabriolet','citadine','autre'];
        $listOfType = [];
        foreach ($types as $oneType) {
            $type = new Type();
            $type->setName($oneType);
            $listOfType[] = $type;
            $entityManager->persist($type);
        }

        $brands = ['Renault', 'Peugeot', 'Honda', 'Fiat'];
        foreach ($brands as $oneBrand){
            $brand = new Brand();
            $brand->setName($oneBrand);
            $entityManager->persist($brand);
        }

        $modelsRenault = ['Renault','Clio', 'Kangoo', 'Scénic', 'Captur'];
        $modelsPeugeot = ['Peugeot','408', '208', '207'];
        $modelsHonda = ['Honda','Civic', 'Jazz'];
        $modelsFiat = ['Fiat','Tipo', 'Panda', '500'];
        $models = [$modelsRenault, $modelsPeugeot, $modelsHonda, $modelsFiat];
        $listOfModel = [];
        $entityManager->flush();
        foreach ($models as $modelsBrand){
            $brand = $entityManager->getRepository(Brand::class)->findOneBy(array('name' => $modelsBrand[0]));
            for ($i=1; $i < count($modelsBrand); $i++){
                $model = new Model();
                $model->setName($modelsBrand[$i]);
                $model->setBrand($brand);
                $listOfModel[] = $model;
                $entityManager->persist($model);
            }
        }

        $options =['Siège Chauffant','Caméra de recul','ABS','AFU','GPS'];
        $ListOfOption = [];
        foreach ($options as $oneOption){
            $option = new Option();
            $option->setName($oneOption);
            $entityManager->persist($option);
            $ListOfOption[]= $option;
        }

        $Capacity = [5, 4, 2, 5, 5];
        $price = [8000,6500,3000,9000,8500];
        $plate = ['FEV5FEZY','FEZ2YFEZ','FE6YGFZF','GEZG3EZN','FNEIFEUZ'];
        $Year = [2015,2008,2014,2011,2017];
        $kms = [140000,130000,200000,100000,50000];
        $imgPaths = ['img/vehicle1.jpg','img/vehicle2.jpg','img/vehicle3.jpg','img/vehicle4.jpg','img/vehicle5.jpg'];
        $vehicles = [];
        $entityManager->flush();

        for ($i=0; $i< 5;$i++){
            $vehicle = new Vehicle();
            $vehicle->setCapacity($Capacity[$i]);
            $vehicle->setPrice($price[$i]);
            $vehicle->setNumberPlate($plate[$i]);
            $vehicle->setYearOfCar($Year[$i]);
            $vehicle->setNumberKilometers($kms[$i]);
            $vehicle->setImgPath($imgPaths[$i]);
            $vehicle->setModel($listOfModel[rand(1,Count($listOfModel))-1]);
            $vehicle->setType($listOfType[rand(1,Count($listOfType))-1]);
            for ($j=0; $j<3;$j++){
                $vehicle->addOption($ListOfOption[$j]);
            }
            $vehicles[]= $vehicle;

            $entityManager->persist($vehicle);
        }
        for ($i=0; $i<3;$i++){
            for ($j=0; $j<5;$j++){
                $ListOfOption[$i]->addVehicle($vehicles[$j]);
                $entityManager->persist($vehicle);
            }
        }

        $stateName = ['annulé','validé','en cours de validation'];
        for ($i=0; $i< 3;$i++){
            $state = new State();
            $state->setStatus($stateName[$i]);
            $entityManager->persist($state);
        }

        $user = new User();
        $user->setEmail('admin@admin.com');

        $user->setRoles(["ROLE_ADMIN"]);

        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);

        $entityManager->persist($user);

        $user2 = new User();
        $user2->setEmail('client@client.com');

        $user2->setRoles(["ROLE_CLIENT"]);

        $password2 = $this->hasher->hashPassword($user2, 'password');
        $user2->setPassword($password2);

        $entityManager->persist($user2);

        $entityManager->flush();
    }
}
