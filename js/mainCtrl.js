

// Module
var myApp = angular.module("myApp",["ngRoute"]);

// Routing
myApp.config(['$routeProvider','$locationProvider',function ($routeProvider,$locationProvider) {
             $locationProvider.hashPrefix('!');
            $routeProvider.when("/", {
                templateUrl: "templates/home.html",
                controller: 'mainCtrl'
            }).when('/login', {
                templateUrl: 'templates/login.html',
                controller: 'loginTabs'
            }).when('/eProfile', {
                templateUrl: 'templates/eProfile.html',
                controller: 'eProfileCtrl'
            }).when('/rLogin', {
                templateUrl: 'templates/rLogin.html',
                controller: 'rloginTabs'
            }).otherwise({
                redirectTo: "/"
            });

    }]);


// Main Controller
myApp.controller("mainCtrl",function($scope,$location,$http){
  // $scope.loading = true;
		var getJobs = function(){
             var jobData = {};
              jobData.function_name = "select";
              $http({
                    method : 'POST',
                    url : 'http://localhost/jobPortal/api/jobdescription.php',
                    data: jobData
                }).then(function successCallback(res) {
                    console.log("Success job data: "+JSON.stringify(res));
                    $scope.jobDescData = res.data.result;
                    console.log("Job Data :"+JSON.stringify($scope.jobDescData));
                    
                }, function errorCallback(err) {
                    console.log(err.statusText);
                });
           }
      getJobs();
      // $scope.loading = false;     
});


//Login and Signup controllers
myApp.controller("loginTabs",function($scope,$http,$location){
    this.tab = 2;
    this.selectTab = function(setTab){
        this.tab = setTab;
    }
    this.isSelected = function(checkTab){
        return this.tab === checkTab;
    }



    $scope.signup = function(){
    var name = $scope.fname +" "+$scope.lname;
   var signupFormData = {};
   signupFormData.name = name;
   signupFormData.email = $scope.signupemail;
   signupFormData.password = $scope.signpassword;
   signupFormData.cpassword = $scope.cpass;
   signupFormData.function_name = "signup";


   $http({
     method: 'POST',
     url: 'http://localhost/jobPortal/api/',
     data : signupFormData,
     headers: {
       "Content-Type": "application/x-www-form-urlencoded"
     }
   }).then(function successCallback(res) {
     console.log("Success :"+JSON.stringify(res));
     $location.path('/login').replace();

   }, function errorCallback(err) {
     console.log("Error :"+JSON.stringify(err));
     $scope.error = JSON.stringify(err);
   });
};

$scope.login = function(){
              var loginFormData = {};
              loginFormData.email = $scope.loginemail;
              loginFormData.password = $scope.logpassword;
              loginFormData.function_name = "login";

              // console.log("Form Data :"+JSON.stringify(loginFormData));

              $http({
                method: 'POST',
                url: 'http://localhost/jobPortal/api/',
                data : loginFormData
              }).then(function successCallback(res){
                // console.log("Success :"+JSON.stringify(res));
                $scope.loginData = res.data.result;
                localStorage.setItem("userId",$scope.loginData.id);
                localStorage.setItem("email",$scope.loginData.E_email);
                localStorage.setItem("name",$scope.loginData.E_name);
                // console.log("Login data:"+JSON.stringify($scope.loginData));
                // console.log("Login Id :"+$scope.loginData.id);
                var userId = localStorage.getItem('userId');
                console.log(userId);
                $location.path('/eProfile').replace();
              }, function errorCallback(err) {
                console.log("Error :"+JSON.stringify(err));
                
              });
            };

});

//Profile controllers
myApp.controller("eProfileCtrl",function($scope){

});




            