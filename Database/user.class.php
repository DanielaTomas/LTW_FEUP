<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $firstLastName;
    public string $username;
    public string $password;
    public string $userAddress;
    public int $phoneNumber;
    public int $restaurant;


    public function __construct(int $id, string $firstLastName, string $username, string $userAddress, int $phoneNumber, int $restaurant)
    {
      $this->id = $id;
      $this->firstLastName = $firstLastName;
      $this->username = $username;
      $this->userAddress = $userAddress;
      $this->phoneNumber = $phoneNumber;
      $this->restaurant = $restaurant;
    }

     
    
    static function getCustomerWithPassword(PDO $db, string $username, string $password) : ?User {
      $stmt = $db->prepare('
        SELECT UserId, FirstLastName, Username, UserAddress, PhoneNumber, RestaurantId
        FROM Users 
        WHERE lower(Username) = ? AND password = ?
      ');

      $stmt->execute(array(strtolower($username), sha1($password)));
  
      if ($user = $stmt->fetch()) {
        return new User(
            intval($user['UserId']),
            $user['FirstLastName'],
            $user['Username'],
            $user['UserAddress'],
            intval($user['PhoneNumber']),
            intval($user['RestaurantId'])
        );
      }

      return null;
    }

  }
?>