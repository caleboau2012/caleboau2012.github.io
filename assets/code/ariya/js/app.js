(function(){
    var app = angular.module('Ariya',['ui.router','ui.bootstrap','cgPrompt','angularMoment','angularModalService','angularFileUpload','fcsa-number','angular-loading-bar']);

    app.constant('AUTH_EVENTS', {
        loginSuccess: 'auth-login-success',
        loginFailed: 'auth-login-failed',
        logoutSuccess: 'auth-logout-success',
        sessionTimeout: 'auth-session-timeout',
        notAuthenticated: 'auth-not-authenticated',
        notAuthorized: 'auth-not-authorized'
    });

    // app.constant('USER_ROLES', {
    //   verified:'verified',
    //   unverified: 'unverified',
    //   guest: 'guest'
    // });

    app.factory('AuthInterceptor', function ($rootScope, $q,AUTH_EVENTS) {
        return {
            responseError: function (response) {
                $rootScope.$broadcast({
                    401: AUTH_EVENTS.notAuthenticated,
                    403: AUTH_EVENTS.notAuthorized,
                    419: AUTH_EVENTS.sessionTimeout,
                    440: AUTH_EVENTS.sessionTimeout
                }[response.status], response);
                return $q.reject(response);
            }
        };
    });

    app.config(function($stateProvider,$urlRouterProvider,$locationProvider) {
        $stateProvider
            .state('home',{
                url:'/',
                templateUrl:'views/partials/index-partial.html',
                data:{
                    requireLogin:false
                }
            })
            .state('login',{
                url:'/login',
                controller:'LoginController',
                templateUrl:'views/login.html',
                data:{
                    requireLogin:false
                },
                params:{
                    destination:null,
                    params:null
                }
            })
            .state('listing',{
                url:'/listing',
                templateUrl:'views/listing.html',
                data:{
                    requireLogin:false
                },
                params:{
                    search:null
                }
            })
            .state('search',{
                url:'/listing/search?{query},{type},{rating},{features},{min_price},{max_price},{page_num}',
                templateUrl:'views/searchview.html',
                data:{
                    requireLogin:false
                }
            })
            .state('contact',{
                url:'/contact',
                templateUrl:'views/contact.html',
                data:{
                    requireLogin:false
                }
            })
            .state('info',{
                url:'/info',
                templateUrl:'views/info.html',
                data:{
                    requireLogin:false
                }
            })
            .state('publish',{
                url:'/publish',
                templateUrl:'views/publish.html',
                data:{
                    requireLogin:false
                }
            })
            .state('faq',{
                url:'/faq',
                templateUrl:'views/faq.html',
                data:{
                    requireLogin:false
                }
            })
            .state('terms',{
                url:'/terms',
                templateUrl:'views/terms.html',
                data:{
                    requireLogin:false
                }
            })
            .state('privacy',{
                url:'/privacy',
                templateUrl:'views/privacy.html',
                data:{
                    requireLogin:false
                }
            })
            .state('rate',{
                url:'/rate',
                templateUrl:'views/rate.html',
                data:{
                    requireLogin:false
                }
            })
            .state('viewProperty',{
                url:'/listing/{id:int}/{property_name}',
                templateUrl:'views/property.html',
                data:{
                    requireLogin:false
                }
            })
            .state('profile',{
                url:'/profile',
                templateUrl:'views/manage.html',
                data:{
                    requireLogin:true
                },
                params:{
                    openNotification:null
                },
                resolve:{
                    auth:function resolveAuthentication(AuthResolver){
                        return AuthResolver.resolve();
                    }
                }
            })
            .state('editProperty',{
                url:'/manage/:id',
                templateUrl:'views/editProperty.html',
                data:{
                    requireLogin:true
                },
                resolve:{
                    auth:function resolveAuthentication(AuthResolver){
                        return AuthResolver.resolve();
                    }
                }
            })
            .state('pay',{
                url:'/pay/:bid_book_id',
                templateUrl:'views/pay.html',
                data:{
                    requireLogin:true
                }
            })
            .state('bidbook',{
                url:'/listing/bid-book/{id}/{property_name}/{date}',
                templateUrl:'views/bid-book.html',
                data:{
                    requireLogin:true
                },
                resolve:{
                    auth:function resolveAuthentication(AuthResolver){
                        return AuthResolver.resolve();
                    }
                }
            })
        $urlRouterProvider.otherwise('/');
        $locationProvider.html5Mode(true);
    });

    app.config(function ($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        // $httpProvider.defaults.transformRequest = [function(data){

        // 	var param = function(obj){
        // 		var query = '';
        // 		var name, value, fullSubName, subName, subValue,innerObj,i;

        // 		for(name in obj){
        // 			value = obj[name];
        // 			if(value instanceof Array){
        // 				for(i =0;i<value.length;i++){
        // 					subValue = value[i];
        // 					fullSubName = name + '['+i+']';
        // 					innerObj = {};
        // 					innerObj[fullSubName] = subValue;
        // 					query += param[innerObj]+'&';
        // 					console.log("query for "+value+" => "+query);
        // 				}
        // 			}else if(value instanceof Object){
        // 				for(subName in value){
        // 					subValue = value[subName];
        // 					fullSubName = name + '['+subName+']';
        // 					innerObj = {};
        // 					innerObj[fullSubName] = subValue;
        // 					query += param[innerObj]+'&';
        // 					console.log(subName +" | " +subValue+" | "+ fullSubName+" | "+JSON.stringify(innerObj));
        // 					console.log("query for "+value+" => "+query);
        // 				}
        // 			}else if(value !== undefined && value !== null){
        // 				query += encodeURIComponent(name)+'='+encodeURIComponent(value)+'&';
        // 			}
        // 		}
        // 		// var k = query.length ? query.substr(0,query.length -1):query;
        // 		// console.log(JSON.stringify(k));
        // 		// return k;
        // 		return query.length ? query.substr(0,query.length -1):query;
        // 	}
        // 	var k = param(data);
        // 	console.log('k is=>'+k);
        // 	return angular.isObject(data)&&String(data) !== '[object File]' ? k:data;
        // }];

        var param = function(obj) {
            var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

            for(name in obj) {
                value = obj[name];

                if(value instanceof Array) {
                    for(i=0; i<value.length; ++i) {
                        subValue = value[i];
                        fullSubName = name + '[' + i + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if(value instanceof Object) {
                    for(subName in value) {
                        subValue = value[subName];
                        fullSubName = name + '[' + subName + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if(value !== undefined && value !== null)
                    query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
            }

            return query.length ? query.substr(0, query.length - 1) : query;
        };

        // Override $http service's default transformRequest
        $httpProvider.defaults.transformRequest = [function(data) {
            var k = angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
            //console.log('k is=>'+k);
            return k;
        }];

        $httpProvider.interceptors.push(['$injector',function ($injector) {
            return $injector.get('AuthInterceptor');
        }
        ]);

        //add token to header when making requests

        // $httpProvider.interceptors.push(function($q, $window) {
        //   return {
        //    'request': function(config) {
        //         config.headers['Token'] = $window.localStorage.token;
        //         return config;
        //     }
        //   };
        // });
    });

    app.config(['fcsaNumberConfigProvider',function(fcsaNumberConfigProvider) {
        fcsaNumberConfigProvider.setDefaultOptions({
            preventInvalidInput: true,
            min:0
        });
    }]);


    app.service('Session', function ($window) {
        this.token = "";
        // if($window.localStorage.token)
        // 	this.token = $window.localStorage.token;
        this.create = function (sessionToken) {
            $window.localStorage.token = sessionToken;
            this.token = sessionToken;
        };
        this.destroy = function () {
            this.token = null;
        };
    });


    app.service('DefaultModalService',function($modal,ModalService,$log, $rootScope){
        var modalOpts = {
            title:"This is a title",
            body:"This is the body"
        };
        this.showModal = function(modalOptions){
            if(!modalOptions){
                modalOptions = modalOpts;
            }
            ModalService.showModal({
                templateUrl:'views/partials/default-modal-partial.html',
                controller:function($scope,close){
                    $scope.modalTitle = modalOptions.title;
                    $scope.modalBody = modalOptions.body;
                    $scope.close = function(result){
                        close(result,500);
                    }
                }
            }).then(function(modal){
                modal.element.modal();
                modal.close.then(function(result) {
                    //$log.log("modal result "+result);
                });
            });
        }

    });

    app.factory('AuthService', function ($log,$http, $window,Session,DefaultModalService,prompt) {
        var authService = {};

        authService.login = function (credentials) {

            return $http
                .post(URL_LOGIN, credentials)
                .success(function(data){
                    $log.log('success '+data.message);
                })
                .error(function(data){
                    $log.log('error '+data.message);
                })
                .then(function (res) {
                    if(!res.data.error){
                        if(res.data.isVerified){
                            $window.localStorage.token = res.data.token;
                            //$log.log("Authservice token=>"+$window.localStorage.token);
                            Session.create(res.data.token);
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        //alert(res.data.message);
                        prompt({title:"Alert!",message:res.data.message});
                        //DefaultModalService.showModal({title:"Alert!",body:res.data.message});
                        return false;
                    }


                });
        };

        authService.register = function(credentials){
            return $http
                .post(URL_REGISTER, credentials)
                .success(function(data){
                    $log.log(data.message);
                })
                .error(function(data){
                    $log.log(data.message);
                })
                .then(function (res) {
                    if(!res.data.error){
                        prompt({title:"Notification",
                        		message:"A Verification Mail has been sent to "+credentials.email+". Please Follow to link provided there to complete registration process.",
                        		buttons:[
                        			{
	                        			"label":"Dismiss",
	                        			"primary":true,
	                        			"cancel":false
	                        		}
                        		]
                        	}).then(function(res){
                        		$state.go('listing');
                        	},function(){
                        		$state.go('listing');
                        	});
                        //DefaultModalService.showModal({title:"Notification",body:"A Verification Mail has been sent to "+credentials.email+". Please Follow to link provided there to complete registration process."});
                    }else{
                        prompt({title:"Alert!", message:res.data.message});
                        //DefaultModalService.showModal({title:"Alert!",body:res.data.message});
                        //return false;
                    }
                });
        };

        authService.isAuthenticated = function () {
            return !!Session.userEmail;
        };

        authService.isAuthorized = function (authorizedRoles) {
            if (!angular.isArray(authorizedRoles)) {
                authorizedRoles = [authorizedRoles];
            }
            return (authService.isAuthenticated() &&
            authorizedRoles.indexOf(Session.userRole) !== -1);
        };

        return authService;
    });


    app.factory('AuthResolver',function($q,$rootScope,$state){
        return {
            resolve:function(){
                var deferred = $q.defer();
                var unwatch = $rootScope.$watch('currentUser',function(currentUser){
                    if(angular.isDefined(currentUser)){
                        if(currentUser){
                            deferred.resolve(currentUser);
                        }else{
                            deferred.reject();
                            $state.go('login');
                        }
                        unwatch();
                    }
                });
                return deferred.promise;
            }
        };
    });

    app.run(function ($window,Session,$http,$log,$rootScope, AUTH_EVENTS, AuthService, $state,$timeout) {
        $rootScope.$on('$stateChangeStart', function (event, next,nextParams,from,fromParams) {

            $log.log("state=>"+next.name);
            $log.log("from=>"+from.name);

            angular.element('.navbar-custom-hide').css('display','block');

            if(next.name == 'home'){
                angular.element('.navbar-custom-hide').addClass('navbar-home');
                angular.element('.navbar-custom-hide').removeClass('navbar-fixed-top');
            }else{
                angular.element('.navbar-custom-hide').removeClass('navbar-home');
                angular.element('.navbar-custom-hide').addClass('navbar-fixed-top');
            }


            if(next.name == 'login'){
            	if($window.localStorage.token || $rootScope.currentUser){
            		if((from.name == '') || (from.name == 'home')){
            			$timeout(function(){
	            			$state.go('listing');
	            		});	
            		}else{
            			$timeout(function(){
	            			$state.go(from.name);
	            		});	
            		}
            	}else{
            		$log.log("not logged in");
            	}
            }

            if(next.data.requireLogin){
                //check if user is logged in
                if($window.localStorage.token){
                    if(!Session.token){
                        //run request to get user info using the token
                        $http.get(URL_GET_PROFILE+"?token="+$window.localStorage.token).success(function(res){
                            $rootScope.currentUser = res.profile;
                            if(next.name == 'login'){
                                event.preventDefault();
                            }
                        });
                        token = $window.localStorage.token;
                        Session.create(token);
                    }
                }else{
                    $timeout(function(){
                        $state.go('login',{destination:next.name,params:nextParams});
                        $log.log("user is not logged in");
                    });
                }
            }else{
                if($window.localStorage.token){
                    if(!Session.token){
                        //run request to get user info using the token
                        $http.get(URL_GET_PROFILE+"?token="+$window.localStorage.token).success(function(res){
                            $rootScope.currentUser = res.profile;
                            if(next.name == 'login'){
                                event.preventDefault();
                            }
                        });
                        token = $window.localStorage.token;
                        Session.create(token);
                    }
                }
            }

            $rootScope.$on('$stateChangeSuccess', function() {
                document.body.scrollTop = document.documentElement.scrollTop = 0;
            });
        });
    });

    app.controller('ApplicationController',function($scope,$rootScope,$window,$timeout,$state,$log){
        // $scope.userRoles = USER_ROLES;
        // $scope.isAuthorized = AuthService.isAuthorized;

        $scope.searchQuery = "";

        if(!$scope.User)
            $scope.User = $rootScope.currentUser;

        $scope.setUser = function (user) {
            $scope.User = user;
        };

        $scope.logout = function(){
            $window.localStorage.removeItem('token');
            $rootScope.currentUser = null;
            $scope.User = null;
            $timeout(function(){
                $state.go('home');
            });
        }


        $scope.findProperty =  function(query){
        	//$scope.searchQuery = "";
        	$state.go('listing',{search:query});
        }
    });

    app.controller('LoginController',function($scope,$state,$http,$window,$log,$timeout,$rootScope,AUTH_EVENTS,AuthService){
        $scope.credentials = {
            email:"",
            password:""
        }
        var to = $state.params.destination;
        //$log.log("destination=>"+$state.params.destination);

        $scope.onUserLogin = function(credentials){
            AuthService.login(credentials).then(function(user){
                if(user){
                    $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
                    // $scope.setUser(user);
                    //$log.log("login token=>"+$window.localStorage.token);
                    $http.get(URL_GET_PROFILE+"?token="+$window.localStorage.token).success(function(res){
                        $rootScope.currentUser = res.profile;
                        //$log.log(JSON.stringify(res));
                        $timeout(function(){
                            if(to){
                                $state.go(to,$state.params.params);
                            }else{
                                $state.go('listing');
                            }

                        });
                    });
                }
            },function(){
                $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
            });
        };

        $scope.showResetView = function(){
            angular.element('#forgot').on('click', function(e){
                e.preventDefault;
                $('.forgot').show('slow');
            });
        }
    });

    app.controller('ResetPasswordController',function($scope,$http,$log,DefaultModalService,prompt){
        $scope.rEmail = {
            email:""
        }

        $scope.resetPassword = function(rEmail){

            $http.post(URL_FORGOT_PASSWORD,rEmail).success(function(res){
                prompt({title:'Notification',message:res.message});
                //DefaultModalService.showModal({title:'Notification',body:res.message});
                //$log.log(res);
            })
                .error(function(res){
                    prompt({title:'Notification',message:res.message});
                    //DefaultModalService.showModal({title:'Notification',body:res.message});
                    //$log.log(res);
                });
        }

    });

    app.controller('RegisterController',function($scope,AuthService,$log,$timeout,$state,DefaultModalService){
        $scope.credentials = {};

        var reset = function(){
            $scope.credentials = {
                email:"",
                password:"",
                fname:"",
                lname:"",
                phone:""
            }
        }

        reset();



        $scope.onUserRegister = function(credentials){
            reset();
            AuthService.register(credentials).then(function(){
                //show modal and give option to open their mail
            });
        }
    });

    app.controller('ProfileController',function($scope,$log,prompt,$rootScope,$http,$window,$state,$timeout,$interval){

        angular.element('.masonry').masonry();

        $scope.properties = {};

        if(!$scope.User)
            $scope.User = $rootScope.currentUser;

        $scope.pUser = $scope.User;
        $scope.countries = WORLD_COUNTRIES;

        $scope.addImage = function(){
            angular.element('#imageTrigger').click();
        }

        angular.element('#imageTrigger').change(function(e){
            var reader = new FileReader();
            var formData = new FormData();
            data =  this.files[0];
            // formData.append('avatar',data);
            // $log.log(formData);
            $scope.pUser.avatar = data;
            reader.onload = function(e){
                $timeout(function(){
                    angular.element('#profileImage').attr('src',e.target.result);
                });
            }
            reader.readAsDataURL(data);
        });

        $scope.editProfile = function(user){
            //move this to authService later
            user.token = $window.localStorage.token;

            var fd = new FormData();
            $.each(user, function(index, val) {
                fd.append(index,val);
            });
            //$log.log(fd);
            $http.post(URL_EDIT_PROFILE,fd,{
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            }).success(function(data){
                $log.log(data);
                $log.log(JSON.stringify($scope.pUser));
                var msg = "";
                if(!data.error){
                	msg = "Your profile has been updated";
                }else{
                	msg = data.message;
                }
                prompt({title:"Notification",message:msg,
                    buttons:[
                        {
                            "label":"Dismiss",
                            "cancel":false,
                            "primary":true
                        }
                    ]
                });
            }).error(function(data){
                $log.log(data);
                prompt({title:"Attention!!",message:"An Error Occured",
                    buttons:[
                        {
                            "label":"Dismiss",
                            "cancel":false,
                            "primary":true
                        }
                    ]
                });
            });
        }



        $scope.addNewProperty = function(){
        	$log.log($scope.User);
        	if($scope.User.accnum != (null||0||"") && ($scope.User.accnum.length >= 10) && ($scope.User.bankcode != (null||0||""))){
        		$state.go("editProperty");	
        	}else{
        		prompt({title:"Attention",
        				message:"Your account information must be updated first before adding a property.",
        				buttons:[
                        {
                            "label":"Dismiss",
                            "cancel":false,
                            "primary":true
                        }
                    ]
        		});
        	}
        }

        $http.get(URL_MY_PROPERTIES+"?token="+$window.localStorage.token).success(function(data){

            $scope.properties = data.my_properties.properties;
            arr = data.my_properties.properties;
            $.each(arr, function(index, val) {
                var d = val.description;
                if(d.length >= MAX_TEXT){
                    val.short_description = d.substr(0,MAX_TEXT)+"...";
                }else{
                    val.short_description = d;
                }
            });
            $scope.properties = arr;
        }).error(function(data){
            $log.log(data);
        });


        $scope.$watch(function(scope){ return $scope.properties},function(){
            //$('.nav-tabs a[data-target="#properties"]').tab('show');
            //$('.nav-tabs a[data-target="#profile"]').tab('show');
            //$('.nav-tabs a[data-target="#properties"]').tab('show');
            $('a[data-target="#properties"]').on('shown.bs.tab', function (e) {
                //console.log(e.target);
                $('.masonry .item').each(function() {
                    $(this).imagesLoaded(function () {
                        angular.element('.masonry').masonry('reloadItems');
                        angular.element('.masonry').masonry('layout');
                        //angular.element('.masonry').masonry();
                        //console.log('done');
                    });
                });
            });
        });

        $scope.actionsArray = [];
        $scope.messagesArray = [];
        $scope.reviewsArray = [];


        $scope.rawNotificationArray = [];
        $scope.notificationArray = [];


        var createAction = function(id,sid,type,pname,price,uname,img,edate,date,opt,email,phone){
        	var p = false;
        	if(type == "bid_accepted" || type == "book_accepted")
        		p = true;

            var noti = {
                id:id,
                s_id:sid,
                type:type,
                property_name:pname,
                property_price:price,
                user_name:uname,
                property_image:img,
                event_date:edate,
                date:date.substr(0, 10),
                options:opt,
                pay:p,
                email: email,
                phone: phone
            }
            return noti;
        }

        var createReview = function(rId,pimage,uname,rating,review,date,email,phone){
        	var msg = review;
        	if(review.length > 100)
        		msg = review.substr(0,100)+"...";

        	var noti = {
        		id:rId,
        		image:pimage,
        		name:uname,
        		rating:rating,
        		review:msg,
        		date:date.substr(0, 10),
                email: email,
                phone: phone
        	}

        	return noti;
        }

        var createMessage = function(uname, pname,pimage,type,edate,date,email,phone){
        	var msg = "";
        	switch(type){
        		case "book_declined":
        			msg = "Sorry, Your Booking has been declined.";
        			break;
        		case "bid_declined":
        			msg = "Sorry, Your Bid has been declined.";
        			break;
        		case "bid_closed":
        			msg = "Biddings for this property have officially been closed."
        			break;
        		case "bid":
        			msg = uname + " placed a Bid for this property."
        			break;
        		case "book":
        			msg = uname + " placed a Booking on this property."
        			break;
        		case "payment_accepted":
					msg = "The property owner just accepted your payment";
					break;
                case "payment_cancelled":
                    msg = "You cancelled your payment for this property";
                    break;
                case "payment_cancelled_owner":
                    msg = "The Client has cancelled his/her payment for this property. ";
                    break;
				case "bid_accepted_owner":
        			msg = "You just accepted a bid";
        			break;
        		case "bid_declined_owner":
        			msg = "You just declined a bid";
        			break;
        		case "book_accepted_owner":
        			msg = "You just accepted a booking";
        			break;
        		case "book_declined_owner":
        			msg = "You just declined a booking";
        			break;
        	}

        	var noti = {
        		name:pname,
        		image:pimage,
        		message:msg,
                event_date:edate,
        		date:date.substr(0, 10),
                email: email,
                phone: phone
        	};

            //console.log(noti);

        	return noti;
        }

        var notificationCaller = $interval(function(){
            getNotifications();
        },NOTIFICATION_INTERVAL);

        $scope.notificationArray = [];

        $scope.$on('$destroy',function(){$interval.cancel(notificationCaller);});



        var getNotifications = function(){
            var marker;
            if($scope.rawNotificationArray.length > 0)
                marker = $scope.rawNotificationArray[0].notification_id;
            //$log.log("marker=>"+marker);
            var extra = "";
            if(marker)
                extra = "&type=newer&marker="+marker;
            $http.get(URL_NOTIFICATIONS+"?token="+$window.localStorage.token+extra).success(function(res){
                // $log.log(res);
                var arr = res.notifications;
                for(var i = arr.length-1; i >= 0; i--){
                    var val = arr[i];
                    var a;
                    console.log(val);
                    if(val.options || val.type == "bid_accepted" || val.type == "book_accepted"){
                        var s = val.property.name.replace(/['"]+/g, '');
                    	a = createAction(val.notification_id,val.subject_id,val.type,s,val.details.price,val.details.user_name,val.property.image,val.details.event_date,val.created_time,val.options,val.details.email_address,val.details.phone_number);
                    	$scope.actionsArray.splice(0,0,a);
                    }else if(val.type == "review"){
                    	a = createReview(val.details.review_id,val.property.image,val.details.user_name,val.details.rating,val.details.review,val.created_time,val.details.email_address,val.details.phone_number);
                    	$scope.reviewsArray.splice(0,0,a);
                    }else{
                    	if(val.property){
                            var s = val.property.name.replace(/['"]+/g, '');
                    		a = createMessage(val.details.user_name, s,val.property.image,val.type,val.details.event_date,val.created_time,val.details.email_address,val.details.phone_number)
                    	}
                    	//a = createMessage(val.property.name,val.property.image,val.type,val.details.event_date,val.created_time)
                    	$scope.messagesArray.splice(0,0,a);
                    }
                    // $scope.notificationArray.splice(0,0,a);
                     $scope.rawNotificationArray.splice(0,0,val);
                }
                 //console.log($scope.rawNotificationArray);
            });
        }

        getNotifications();

        if($state.params.openNotification){
            angular.element("#notiTab").tab('show');
        }

        // $scope.selectProperty = function(property){
        // 	var name = property.name;
        // 	name = name.replace(" ","-");
        // 	var p_id = property.property_id+"-"+name;
        // 	$state.go('editProperty(id:'+p_id+')');
        // }

        $scope.performNotificationAction = function(index, s){
            if(index < $scope.actionsArray.length){
                var noti = $scope.actionsArray[index];
                var stat = "declined";
                if(s == 1){
                    stat = "accepted"
                }
                var obj={
                    notification_id:noti.id,
                    status:stat,
                    token:$window.localStorage.token
                }
                $log.log(obj);
                $http.post(URL_NOTIFICATION_ACTION,obj)
                    .success(function(res){                        
                        $timeout(function(){
                        	$log.log(res);
                        	$scope.actionsArray.splice(index,1);	
                        });
                        // if($scope.rawNotificationArray[index].type == "book" && stat == "accepted"){
                        // 	$state.go("pay",{bid_book_id:$scope.rawNotificationArray[index].details.bid_book_id});
                        // }
                        prompt({title:"Notification",
		        				message:"Successful!!!",
		        				buttons:[
		                        {
		                            "label":"Dismiss",
		                            "cancel":false,
		                            "primary":true
		                        }
		                    ]
		        		});
                    })
                    .error(function(res){
                    	prompt({title:"Attention",
		        				message:"Oops...an error occured",
		        				buttons:[
		                        {
		                            "label":"Dismiss",
		                            "cancel":false,
		                            "primary":true
		                        }
		                    ]
		        		});
                    });
            }
        }

        $scope.pay = function(id,status){
            if(status){
                var bId;
                for(var i = 0; i< $scope.rawNotificationArray.length;i++){
                    if($scope.rawNotificationArray[i].notification_id == id){
                        bId = $scope.rawNotificationArray[i].details.bid_book_id;
                        break;
                    }
                }
                $state.go("pay",{bid_book_id:bId});    
            }else{
                var obj = {
                    notification_id:id,
                    token:$window.localStorage.token   
                }
                $http.post(URL_CANCEL_PAYMENT,obj)
                .success(function(res){
                    $log.log(res);

                    prompt({title:"Notification",
                            message:"Your action has been carried out.",
                            buttons:[
                                        {
                                            "label":"Dismiss",
                                            "primary":true,
                                            "cancel":false
                                        }
                            ]
                    });
                    $timeout(function(){
                        for(var i = 0;i < $scope.actionsArray.length;i++){
                            if($scope.actionsArray[i].id == id){
                                $scope.actionsArray.splice(i,1);
                                break;
                            }
                        }
                    });
                })
                .error(function(res){
                    $log.log(res);
                });
            }
        	
        }

    });

    app.controller('ChangePasswordController',function($scope,$http,DefaultModalService,$log,$window,prompt){
        $scope.passwords = {
            oldpassword:"",
            newpassword:"",
            confirmnewpassword:""
        }

        $scope.changePassword = function(passwords){
            token = $window.localStorage.token;
            if(passwords.confirmnewpassword == passwords.newpassword){
                passwords.token = $window.localStorage.token;
                $http.post(URL_CHANGE_PASSWORD,passwords).success(function(res){
                    $log.log(res);
                    $scope.passwords = {};
                    prompt({title:'Notification',message:res.message});
                    //DefaultModalService.showModal({title:'Notification',body:res.message});
                }).error(function(res){
                    $log.log(res);
                    prompt({title:'Notification',message:res.message});
                    //DefaultModalService.showModal({title:'Alert',body:res.message});
                });
            }else{
                prompt({title:'Alert!',message:'New Password and Confirm Password Fields dont match.'});
                //DefaultModalService.showModal({title:'Alert!',body:'New Password and Confirm Password Fields dont match.'});
            }
        }
    });

    app.controller('EditPropertyController',function($http,$scope,$log,$timeout,
                                                     $window,ModalService, FileUploader,$state){

        $scope.property = {
            name:"",
            street:"",
            description:"",
            category:1,
            city:"",
            state:"",
            country:"Nigeria",
            booking_price:0,
            min_bid_price:0,
            power:0,
            security:0,
            water:0,
            accessibility:0,
            bar:0,
            ac:false,
            bpower:false,
            internet:false,
            pool:false,
            parking:false,
            restroom:false
            // longitude:3.3762144701172474,
            // latitude:6.521614976011099
        };

        $scope.property.events = [];
        $scope.multipleEventName = "Private";




        if($state.params.id !== null && $state.params.id !== ''){
            // f_id = $state.params.id;;
            // id = f_id.substring(0,f_id.indexOf('-'));
            id = $state.params.id;
            $http.get(URL_GET_MY_PROPERTY+"?property_id="+id+"&token="+$window.localStorage.token).success(function(data){
                if(!data.error){
                    //$log.log('data is=>'+JSON.stringify(data));
                    $scope.property = data.property;
                    $scope.images = data.property.images
                    if($scope.property.events){
                        $.each($scope.property.events, function(index, val) {
                            val.flag = "old";
                            val.classname = "legend-book";
                        });
                    }else{
                        $scope.property.events = [];
                    }
                    initial_image_count = $scope.images.length;
                    p_id = data.property.property_id;
                }
                $log.log(data);
            }).error(function(data){
                $log.log(data);
            });
        }else{
            $scope.property.longitude = 3.3762144701172474;
            $scope.property.latitude = 6.521614976011099;
            $log.log("stateparam.id =>"+$state.params.id);
        }


        $scope.images = [];
        var selectedImage = {};
        var epc = this;

        var uploader = $scope.uploader = new FileUploader({
            url:URL_ADD_PROPERTY_IMAGE
        });
        var p_id;
        var initial_image_count = 0;

        var showGoToProfile = function(){
            if($scope.isSaved){
                angular.element('#saveProperty').css('display','none');
                angular.element('#goToProfile').css('display','block');
            }else{
                angular.element('#saveProperty').css('display','block');
                angular.element('#goToProfile').css('display','none');
            }
        };


        $scope.isSaved = false;
        showGoToProfile();

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 7;
            }
        });

        uploader.onAfterAddingFile = function(fileItem) {
            var reader = new FileReader();
            reader.readAsDataURL(fileItem._file);
            reader.onload = function(e){
                $timeout(function(){
                    //fileItem.imageSrc = e.target.result;
                    $scope.appendImage(e.target.result);
                });

            }

            //console.info('onAfterAddingFile', fileItem);
        };


        $scope.propertyCategories = PROPERTY_CATEGORIES;
        $scope.statRating = STAR_RATINGS;
        $scope.countries = WORLD_COUNTRIES;

        $scope.addImage = function(){
            angular.element('#addPropertyImage').click();
        }

        $scope.submitPropertyDetails = function(property){
            property.token = $window.localStorage.token;
            $log.log(JSON.stringify(property));
            $http.post(URL_ADD_PROPERTY , property).success(function(data){
                $log.log("success=>"+JSON.stringify(data));
                //uploader.url += '?property_id='+data.property_id;
                p_id = data.property_id;
                $log.log(uploader.url);
                $scope.isSaved = true;
                showGoToProfile();
                uploader.uploadAll();
            })
                .error(function(data){
                    $log.log("error=>"+data);
                });

        };

        uploader.onCompleteAll = function(){
            $state.go('profile');
        }

        uploader.onBeforeUploadItem = function(item){
            item.formData.push({property_id:p_id});
            console.log(item);
        };




        //  	$scope.submitPropertyImages = function(property){
        //  		//uploader.url += '?property_id='+75;
        //          //$log.log("form data");
        // $log.log(uploader.url);
        // uploader.uploadAll();
        //  	}



        // angular.element('#addPropertyImage').change(function(e){
        // 	var arr = this.files;
        // 	var reader = new FileReader();
        // 	var img = {};
        // 	reader.onload = function(e){
        // 		img.src = e.target.result;
        // 		$scope.appendImage(img);
        // 	}
        // 	$.each(arr, function(index, element){
        // 		img.data = element;
        // 		reader.readAsDataURL(element);
        // 	});
        // });

        $scope.appendImage = function(source){
            data = {
                src:source
            }
            $timeout(function(){
                if($scope.images.length < 7){
                    $scope.images.push(data);
                }
            });
        }

        $scope.deleteProperty = function(){
            if(p_id){
                data = {
                    property_id:p_id,
                    token:$window.localStorage.token
                }
                $http.post(URL_DELETE_PROPERTY,data).success(function(data){
                    $log.log("delete property success=>"+data);
                    $state.go('profile');
                }).error(function(data){
                    $log.log("delete property error=>"+data);
                })
            }else{
                $log.log("no property id");
            }
        }

        $scope.saveEvents = function(){
            $log.log($scope.property.events);
            $.each($scope.property.events, function(index, val) {
                if(val.flag == "add"){
                    var obj = {
                        property_id:$scope.property.property_id,
                        date:val.date,
                        title:val.title,
                        token:$window.localStorage.token
                    }
                    $http.post(URL_ADD_EVENT, obj).success(function(data){
                        $log.log(data);
                        val.event_id = data.event_id;
                        val.classname = "legend-book";
                    }).error(function(data){$log.log(data)});
                }else if(val.flag == "delete"){
                    var obj = {
                        property_id:$scope.property.property_id,
                        event_id:val.event_id,
                        token:$window.localStorage.token
                    }
                    $http.post(URL_REMOVE_EVENT, obj).success(function(data){
                        $log.log(data);
                        $scope.property.events.splice(index,1);
                    }).error(function(data){$log.log(data)});
                }
            });
            $state.go('profile');
        }

        //   	$scope.submitPropertyDetails = function(property){
        //   		$http.post('http://path/to/some/url',property);
        //   		$log.log(JSON.stringify(property));
        //   	}

        //   	$scope.submitPropertyImages = function(property){
        //   		$timeout(function(){
        //   			var formData = new FormData();
        //   			$.each(property.images, function(index, val) {
        //   				 formData.append('file',val.data);
        //   			});
        //   			$http.post('http://path/to/some/url',formData);
        //   			//$log.log(JSON.stringify(property));
        //   		})
        //   	}

        $scope.removeImage = function(index){
            //$log.log("image_id=>"+$scope.images[index].id+"||"+"property_id=>"+p_id);
            if($scope.images[index].id && p_id){
                //make async call to delete image
                data = {
                    property_id:p_id,
                    image_id:$scope.images[index].id,
                    token:$window.localStorage.token
                }
                $http.post(URL_DELETE_IMAGE,data).success(function(data){
                    $log.log('remove image success=>'+JSON.stringify(data));
                    --initial_image_count;
                }).error(function(data){
                    $log.log('remove image data=>'+JSON.stringify(data));
                });
                $scope.images.splice(index,1);
            }else{
                $scope.images.splice(index,1);
                uploader.removeFromQueue(index -initial_image_count);
            }

        }

        //   	$scope.viewImage = function(index){
        //   		selectedImage= $scope.property.images[index];
        //   		selectedImage.index = index;
        // 	ModalService.showModal({
        // 		templateUrl:'views/partials/view-image-modal-partial.html',
        // 		controller:function($scope,close){
        // 			$scope.image = selectedImage;
        // 			$scope.delete = function(index){
        // 				epc.deleteImage(index);
        // 				close('');
        // 			}
        // 		 	$scope.close = function(){
        // 		 		close('');
        // 		 	}
        // 		}
        // 	}).then(function(modal){
        // 		modal.element.modal();
        //            modal.close.then(function(result) {
        //                //$log.log("modal result "+result);
        //            });
        // 	});
        // }




        //map code was formerly here

    });


    app.directive('myCalendar',function(){
        return {
            restrict:'E',
            scope:{
                property:'=',
                editable:'=',
                multiple:'=',
                multipleName:'=n'
            },
            controller:function($scope,$log,$window,$timeout){
                //var eventData = [];
                $scope.eventData = $scope.property.events;
                $scope.holder = $scope.property.myEvents;
                //$log.log($scope.property);

                var initializeCal = function(d){
                    // if($scope.eventData== (""||undefined))
                    // 	$scope.eventData = [];

                    var now = new Date();
                    var y = now.getFullYear();
                    var m = now.getMonth() + 1;
                    var lastEvent = {};
                    if(d){
                        lastEvent.date = d;
                    }else{
                        //lastEvent = $scope.eventData[$scope.eventData.length-1];
                    }
                    if(lastEvent.date){
                        m = lastEvent.date.split("-")[1];
                        y = lastEvent.date.split("-")[0];
                    }
                    var lgnd = [
                        {type: "block", label: "Unavailable", classname: "legend-book"},
                        {type: "block", label: "Bid in progress", classname: "legend-bid"},
                        {type: "block", label: "Today", classname: "legend-today"},
                    ];
                    if($scope.multiple){
                        lgnd.push({type: "block", label: "Selected", classname: "legend-selected"});
                        lgnd.push({type: "block", label: "Deleted", classname: "legend-deleted"});
                        lgnd.splice(1, 1);
                    }
                    angular.element("#my-calendar").zabuto_calendar({
                        data:$scope.eventData,
                        today:true,
                        year:y,
                        month:m,
                        legend:lgnd,
                        action:function(){
                            if($scope.multiple){
                                return editHolder(this.id);
                            }else{
                                return toggleEvent(this.id);
                            }
                        }
                    });
                }

                var reloadCal = function(date){
                    angular.element("#calendarHolder").html("");
                    angular.element("#calendarHolder").append("<div id='my-calendar'></div>");
                    $timeout(function(){
                        initializeCal(date);
                    });
                }

                // $(function(mmm){
                // 	$log.log("reloading cal");
                // 	reloadCal();
                // });

                $scope.$watch('property.events',function(newval){
                    if(newval){
                        $scope.eventData = newval;
                        reloadCal();
                        $log.log(newval);
                    }
                    $log.log("----------- watch me now"+newval);
                });





                // var toggleEvent = function(id){
                //     if($scope.editable){
                //         var date = angular.element("#" + id).data("date");
                //         var hasEvent = angular.element("#" + id).data("hasEvent");
                //         if(hasEvent){
                //             var i;
                //             for(var k = 0;k<$scope.eventData.length;k++){
                //                 if($scope.eventData[k].date == date){
                //                     i = k;
                //                     break;
                //                 }
                //             }
                //             if($scope.eventData[i].flag == ("add"||"old")){
                //             	if($scope.eventData[i].flag == "add"){
                //             		$scope.eventData.splice(i,1);	
                //             	}else if($scope.eventData[i].flag == "old"){
                //             		$scope.eventData[i].flag = "delete";
                //             		$scope.eventData[i].classname = "legend-deleted";	
                //             	}
                //             	reloadCal(date);
                //             }else if($scope.eventData[i].flag == "delete"){
                //             	$scope.eventData[i].flag = "old";
                //             	$scope.eventData[i].classname = "legend-book";
                //             	reloadCal(date);
                //             }

                //             // 
                //             // $scope.holder.splice(i,1);
                //         }else{
                //             var name = prompt("Enter Event name", "");
                //             if(name != null && name != ""){
                //                 name += " ("+date+")";
                //                 $scope.eventData.push({"date":date,"badge":false,"title":name,"classname":"legend-selected","flag":"add"});
                //                 // $scope.holder.push({"date":date,"badge":false,"title":name, "classname":"legend-selected"});
                //                 reloadCal(date);
                //             }
                //         }
                //     }
                // }

                var toggleEvent= function(id){
                    if($scope.editable){
                        var date = angular.element("#" + id).data("date");
                        var hasEvent = angular.element("#" + id).data("hasEvent");
                        if(new Date().getTime() <= (new Date(date).getTime()+this.HOURS_24_MILLI)){
                            for(var k = 0;k<$scope.eventData.length;k++){
                                if(($scope.eventData[k].flag == "add"))
                                    $scope.eventData.splice(k,1);
                            }
                            if(!hasEvent){
                                $scope.eventData.push({"date":date,"badge":false,"title":"","classname":"legend-selected","flag":"add"});
                                reloadCal(date);
                            }else{
                                for(var k = 0;k<$scope.eventData.length;k++){
                                    if(($scope.eventData[k].status == "in_progress") || ($scope.eventData[k].status == "cancelled")){
                                        if($scope.eventData[k].date == date){
                                            $scope.eventData.push({"date":date,"badge":false,"title":"","classname":"legend-selected","flag":"add"});
                                            reloadCal(date);
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                    }
                }

                var editHolder = function(id){
                    if($scope.editable){
                        var date = angular.element("#" + id).data("date");
                        var hasEvent = angular.element("#" + id).data("hasEvent");

                        if(hasEvent){
                            var i;
                            for(var k = 0;k<$scope.eventData.length;k++){
                                if($scope.eventData[k].date == date){
                                    i = k;
                                    break;
                                }
                            }
                            if(($scope.eventData[i].flag == "add") || ($scope.eventData[i].flag == "old")){
                                if($scope.eventData[i].flag == "add"){
                                    $scope.eventData.splice(i,1);
                                }else if($scope.eventData[i].flag == "old"){
                                    $scope.eventData[i].flag = "delete";
                                    $scope.eventData[i].classname = "legend-deleted";
                                }
                                reloadCal(date);
                            }else if($scope.eventData[i].flag == "delete"){
                                $scope.eventData[i].flag = "old";
                                $scope.eventData[i].classname = "legend-book";
                                reloadCal(date);
                            }

                            // $scope.eventData.splice(i,1);
                            // $scope.holder.splice(i,1);
                        }else{
                            $scope.eventData.push({"date":date,"badge":false,"title":$scope.multipleName, "classname":"legend-selected","flag":"add"});
                            // $scope.holder.push({"date":date,"badge":false,"title":$scope.multipleName, "classname":"legend-selected"});
                            reloadCal(date);
                        }
                    }
                }
            },
            templateUrl:'views/partials/calendar-partial.html'
        }
    });




    app.directive('propertyMap',function(){
        return{
            restrict:'E',
            scope:{
                longitude:'=',
                latitude:'=',
                draggable:'=',
                zoom:"="
            },
            controller:function($scope,$timeout,$log,$interval,$document,$window){
                /***********************Google maps BS*********/
                //$log.log($scope.longitude+"||"+$scope.latitude);

                var map;
                var marker;
                $log.log("lng and lat=>"+$scope.longitude+"||"+$scope.latitude);
                // if($scope.latitude == (""||undefined) || $scope.longitude == (""||undefined)){
                // 	$scope.latitude = 6.521614976011099;
                // 	$scope.longitude = 3.3762144701172474;
                // 	var myLatlng = new google.maps.LatLng(6.521614976011099,3.3762144701172474);
                // }else{
                // 	var myLatlng = new google.maps.LatLng($scope.latitude,$scope.longitude);
                // }

                //$log.log(myLatlng);


                function initialize(){
                    var myLatlng = new google.maps.LatLng($scope.latitude,$scope.longitude);
                    var geocoder = new google.maps.Geocoder();
                    var infowindow = new google.maps.InfoWindow();

                    var mapOptions = {
                        zoom: $scope.zoom,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    var myMap = document.getElementById("myMap");

                    map = new google.maps.Map(myMap, mapOptions);

                    marker = new google.maps.Marker({
                        map: map,
                        position: myLatlng,
                        draggable: $scope.draggable
                    });

                    geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                //$('#address').val("an address");
                                // $('#latitude').val(marker.getPosition().lat());
                                // $('#longitude').val(marker.getPosition().lng());
                                $timeout(function(){
                                    // $scope.latitude = marker.getPosition().lat();
                                    // $scope.longitude = marker.getPosition().lng();
                                    angular.element('#latitude').val($scope.latitude);
                                    angular.element('#longitude').val($scope.longitude);
                                    infowindow.setContent(results[0].formatted_address);
                                    infowindow.open(map, marker);
                                });
                            }
                        }else{
                            $log.log('error');
                        }
                    });


                    google.maps.event.addListener(marker, 'dragend', function() {

                        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[0]) {
                                    //$('#address').val(results[0].formatted_address);
                                    //$('#latitude').val(marker.getPosition().lat());
                                    $timeout(function(){
                                        $scope.latitude = marker.getPosition().lat();
                                        $scope.longitude = marker.getPosition().lng();
                                        angular.element('#latitude').val($scope.latitude);
                                        angular.element('#longitude').val($scope.longitude);
                                        $log.log($scope.longitude+"||"+$scope.latitude);
                                        infowindow.setContent(results[0].formatted_address);
                                        infowindow.open(map, marker);
                                    });

                                    //$('#longitude').val(marker.getPosition().lng());

                                }
                            }else{
                                $log.log('2nd error');
                            }

                        });
                    });

                }
                $scope.$watch(function(scope){return $scope.longitude},function(newVal){
                    $log.log("newVal=>"+newVal);
                    if(newVal != undefined)
                        initialize()
                },true);








                //google.maps.event.addDomListener($window, 'load', initialize);


                /******************END OF GOOGLE MAPS BS****************************/
            },
            templateUrl:'views/partials/map-partial.html'
        }
    })

    app.controller('ListingController',function($scope,$window,$log,$http,$state,$timeout){

    	angular.element('.masonry').masonry();

    	$scope.currentPage = 1;
		$scope.totalCount = 100;
		$scope.maxCount = 5;
		$scope.itemsPerPage = 10;
		$scope.numPages;

    	if($state.params.search){
    		params = {
    			query:$state.params.search
    		}
    		$timeout(function(){
    			$state.go('search',{query:$state.params.search,type:null,features:null,rating:null,page_num:null});
    		});
    		
    	}

    	$scope.changePage = function(){
			$log.log($scope.currentPage);
			//var q = buildQuery($scope.currentPage);
			getProperties($scope.currentPage);
		}

		var getProperties = function(page_num){
			var extra = "";
			if(page_num)
				extra = "&page_num="+page_num;

			$http.get(URL_SEARCH+"?token="+$window.localStorage.token+extra).success(function(data){
	        	
	            var arr = data.results.properties;

	            $scope.maxPrice = data.results.max_price;
	            $scope.totalCount = data.results.result_num;

	            $.each(arr, function(index, val) {
	                var s = val.name.replace(/['"]+/g, '');;
	                var d = val.description;
	                if(d.length >= MAX_TEXT){
	                    val.short_description = d.substr(0,MAX_TEXT)+"...";
	                }else{
	                    val.short_description = d;
	                }
	                val.other_name = s.replace(/ /g,'-');
	            });
	            //$log.log(arr);
	            $scope.propertyList = arr;
	            $scope.$watch($scope.propertyList, function() {
	                // $('.masonry .item').each(function() {
	                //     $(this).imagesLoaded(function () {
	                //         $('.masonry').masonry();
	                //         console.log('done');
	                //     });
	                // });
	            	$timeout(function(){
	            		$('.masonry .item').each(function() {
		                    $(this).imagesLoaded(function () {
		                        angular.element('.masonry').masonry('reloadItems');
		                        angular.element('.masonry').masonry('layout');
		                        //angular.element('.masonry').masonry();
		                        //console.log('done');
		                    });
		                });
	            	});
	            });
	        }).error(function(data){
	            $log.log(data);
	        });
		}

		getProperties();

        
    });

	
	app.controller('SearchPageController',function($scope,$window,$log,$http,$state,$timeout){

		angular.element('.masonry').masonry();

		$scope.currentPage = 1;
		$scope.totalCount = 100;
		$scope.maxCount = 5;
		$scope.itemsPerPage = 10;
		$scope.numPages;

		$scope.search = {
			
		};

		$scope.noResult = false;

		//$log.log($state.params);

		$scope.changePage = function(){
			$log.log($scope.currentPage);
			var q = buildQuery($scope.currentPage);
			makeRequest(q);
		}

		var buildQuery = function(page_num){
			var query = "";
			if($state.params.query != (""||null||undefined)){
				if(query.length != 0){
					query += "&query="+$state.params.query;
				}else{
					query += "?query="+$state.params.query;
				}
			}
			$log.log("price=>"+$state.params.max_price);
			if($state.params.max_price != (0||""||null||undefined)){
				if(query.length != 0){
					query += "&min_price=0&max_price="+$state.params.max_price;
				}else{
					query += "?min_price=0&max_price="+$state.params.max_price;
				}
			}
			if($state.params.type != (""||null||undefined)){
				if(query.length != 0){
					query+="&type="+$state.params.type;
				}else{
					query+="?type="+$state.params.type;
				}
			}
			if($state.params.rating != (""||null||undefined)){
				if(query.length != 0){
					query+="&rating="+$state.params.rating;
				}else{
					query+="?rating="+$state.params.rating;
				}
			}
			if($state.params.features != (""||null||undefined)){
				if(query.length != 0){
					query+="&features="+$state.params.features;
				}else{
					query+="?features="+$state.params.features;
				}
			}

			if(page_num){
				query+="page_num="+page_num;
			}

			$log.log(query);
			return URL_SEARCH+query;
		}

		var q = buildQuery();

		var makeRequest = function(query){
			$http.get(q).success(function(data){
	        	//$log.log(data);
	            var arr = data.results.properties;
	            $scope.maxPrice = data.results.max_price;
	            //$scope.search.price = $scope.maxPrice;
	            angular.element('#searchPrice').val(parseInt($scope.maxPrice));
	            angular.element('#searchPrice').attr('val',parseInt($scope.maxPrice));
	            $scope.totalCount = data.results.result_num;

	            if(parseInt(data.results.result_num) == 0){
	            	$scope.noResult = true;
	            }

	            $.each(arr, function(index, val) {
	                var s = val.name.replace(/['"]+/g, '');;
	                var d = val.description;
	                if(d.length >= MAX_TEXT){
	                    val.short_description = d.substr(0,MAX_TEXT)+"...";
	                }else{
	                    val.short_description = d;
	                }
	                val.other_name = s.replace(/ /g,'-');
	            });
	            // $log.log(arr);
	            $scope.propertyList = arr;
	            $scope.$watch('propertyList', function() {
	                // $('.masonry .item').each(function() {
	                //     $(this).imagesLoaded(function () {
	                //         $('.masonry').masonry();
	                //         console.log('done');
	                //     });
	                // });
		            $timeout(function(){
		            	angular.element('.masonry').masonry();
		            	$('.masonry').find('.item').each(function() {
		                    $(this).imagesLoaded(function () {
		                        angular.element('.masonry').masonry('reloadItems');
		                        angular.element('.masonry').masonry('layout');
		                        //angular.element('.masonry').masonry();
		                        //console.log('done');
		                    });
		                });
		            });
	            	
	            });
	        }).error(function(data){
	            $log.log(data);
	        });
		}

		makeRequest(q);


		$scope.filter = {
			type:{},
			rating:{},
			features:{}
		};

		




		$scope.searchParams = {
			type:[],
			rating:[],
			features:[]
		};

		angular.element('#searchPrice').change(function(e){
			$log.log($scope.search.price);
			packParams();
		});

		// $scope.$watch('search.price',function(newval){
		// 	if(newval){
		// 		$log.log(newval);	
		// 	}else{
		// 		$log.log("no new val");
		// 	}
		// });

		$scope.submitQuery = function(){
			packParams();
		}

		$scope.toggleParam = function(type,value,isChecked){
			if(isChecked){
				addParam(type,value);
			}else{
				removeParam(type,value);
			}
		}

		var addParam = function(type,value){
			switch(type){
				case 0:
					$scope.searchParams.type.push(value);
					break;
				case 1:
					$scope.searchParams.rating.push(value);
					break;
				case 2:
					$scope.searchParams.features.push(value);
					break;

				default:
					
					break;
			}
			packParams();
		}

		var removeParam = function(type,value){
			switch(type){
				case 0:
					var i = $scope.searchParams.type.indexOf(value);
					$scope.searchParams.type.splice(i,1);
					break;
				case 1:
					var i = $scope.searchParams.rating.indexOf(value);
					$scope.searchParams.rating.splice(i,1);
					break;
				case 2:
					var i = $scope.searchParams.features.indexOf(value);
					$scope.searchParams.features.splice(i,1);
					break;
				default:
					
					break;
			}

			packParams();
		}

		var packParams = function(){
			$scope.search.type = arrayToCSV($scope.searchParams.type);
			$scope.search.rating = arrayToCSV($scope.searchParams.rating);
			$scope.search.features= arrayToCSV($scope.searchParams.features);
			$log.log($scope.search);
			$timeout(function(){
				$state.go('search',{query:$scope.search.query,
									type:$scope.search.type,
									rating:$scope.search.rating,
									features:$scope.search.features,
									max_price:$scope.search.price,
									min_price:undefined
								});	
			});
			
		}

		var arrayToCSV = function(array){
			$scope.searchParams.type.sort();
			$scope.searchParams.rating.sort();
			var s = "";
			for(var i = 0;i<array.length;i++){
				s+=array[i];
				if(i < array.length-1)
					s+=',';
			}
			return s;
		}

		var markCurrentParams = function(){
			$scope.search.query = $state.params.query;
			$log.log($state.params)
			if($state.params.type){
				if($state.params.type.length > 1){
					var array = $state.params.type.split(',');
					for(var i=0;i<array.length;i++){
						markType(parseInt(array[i]));
					}
				}else{
					markType(parseInt($state.params.type));
				}
			}
			if($state.params.rating){
				if($state.params.rating.length > 1){
					var array = $state.params.rating.split(',');
					for(var i=0;i<array.length;i++){
						markRating(parseInt(array[i]));
					}	
				}else{
					markRating(parseInt($state.params.rating));
				}
				
			}

			if($state.params.features){
				if($state.params.features.length > 1){
					var array = $state.params.features.split(',');
					for(var i=0;i<array.length;i++){
						markFeatures(array[i]);
					}	
				}else{
					markFeatures(parseInt($state.params.features));
				}
			}

			if($state.params.max_price){
				$scope.search.price = $state.params.max_price;
				angular.element('#searchPrice').val($scope.search.price);		
			}
		}


		var markType = function(index){
			switch(index){
				case 1:
					$scope.filter.type.hall = true;
					$scope.searchParams.type.push(1);
					break;
				case 2:
					$scope.filter.type.office = true;
					$scope.searchParams.type.push(2);
					break;
				case 3:
					$scope.filter.type.rooftop = true;
					$scope.searchParams.type.push(3);
					break;
				case 4:
					$scope.filter.type.compound = true;
					$scope.searchParams.type.push(4);
					break;
				case 5:
					$scope.filter.type.gardens = true;
					$scope.searchParams.type.push(5);
					break;
				case 6:
					$scope.filter.type.conference_room = true;
					$scope.searchParams.type.push(6);
					break;
			}
		}

		var markRating = function(index){
			switch(index){
				case 1:
					$scope.filter.rating.one = true;
					$scope.searchParams.rating.push(1);
					break;
				case 2:
					$scope.filter.rating.two = true;
					$scope.searchParams.rating.push(2);
					break;
				case 3:
					$scope.filter.rating.three= true;
					$scope.searchParams.rating.push(3);
					break;
				case 4:
					$scope.filter.rating.four = true;
					$scope.searchParams.rating.push(4);
					break;
				case 5:
					$scope.filter.rating.five = true;
					$scope.searchParams.rating.push(5);
					break;
			}
		}

		var markFeatures = function(index){
			switch(index){
				case 'ac':
					$scope.filter.features.ac = true;
					$scope.searchParams.features.push('ac');
					break;
				case 'pool':
					$scope.filter.features.pool= true;
					$scope.searchParams.features.push('pool');
					break;
				case 'bar':
					$scope.filter.features.bar= true;
					$scope.searchParams.features.push('bar');
					break;
				case 'internet':
					$scope.filter.features.internet = true;
					$scope.searchParams.features.push('internet');
					break;
				case 'bpower':
					$scope.filter.features.bpower = true;
					$scope.searchParams.features.push('bpower');
					break;
				case 'parking':
					$scope.filter.features.parking = true;
					$scope.searchParams.features.push('parking');
					break;
				case 'restroom':
					$scope.filter.features.restroom = true;
					$scope.searchParams.features.push('restroom');
					break;
			}
		}

		markCurrentParams();
        
    });


    app.controller('ReviewController',function($scope,$window,$log,$http,$state,prompt,$timeout,$rootScope){

        $scope.reviewArray = [];

        $scope.disableReviewLoadMore = false;

        var resetReview = function(){
            $scope.reviewRate = 3;
            $scope.reviewText = "";
            angular.element('#reviewTextArea').val("");
        }

        resetReview();
        $scope.max = 5;
        $scope.isReadonly = false;

        $scope.hoveringOver = function(value) {
            $scope.overStar = value;
            $scope.percent = 100 * (value / $scope.max);
        };

        var getOldReviews = function(id){
        	var extra = "";
        	
    		var marker = $scope.reviewArray[$scope.reviewArray.length -1].review_id;
        	if(marker)
        		extra = "&type=older&marker="+marker;
	        	

        	$http.get(URL_GET_REVIEW+"?property_id="+id+extra)
                .success(function(res){
                    // $log.log("reviews success");
                    $log.log(res);

                    if(!res.error){
                    	var arr = res.review;
                    	if(arr.length > 0){
                    		for(var i = 0;i<arr.length;i++){
                    			//5 reviews per page
	                    		if(i <= 5){
	                    			$scope.reviewArray.push(arr[i]);
	                    		}else{
	                    			break;
	                    		}
	                    	}	
                    	}else{
                    		$scope.disableReviewLoadMore = true;
                    	}
                    }
                    resetReview();
                })
                .error(function(res){
                    $log.log("reviews error");
                    $log.log(res);
                });
        }

        var getReviews = function(id){

        	$http.get(URL_GET_REVIEW+"?property_id="+id)
                .success(function(res){
                    // $log.log("reviews success");
                    $log.log(res);

                    if(!res.error){
                    	var arr = res.review;
                    	if(arr.length > 0){
                    		for(var i = 0;i<arr.length;i++){
	                    		if(i <= 4){
	                    			$scope.reviewArray.push(arr[i]);
	                    		}else{
	                    			break;
	                    		}
	                    	}
                    	}else{
                    		$scope.disableReviewLoadMore = true;
                    	}
                    }

                    resetReview();
                })
                .error(function(res){
                    $log.log("reviews error");
                    $log.log(res);
                });
        }

        if($state.params.id !== null && $state.params.id !== ''){
            $scope.id = $state.params.id;
            getReviews($scope.id);
        }

        $scope.loadMoreReviews = function(){
        	getOldReviews($scope.id);
        }

        $scope.addReview = function(rv,rt){
            var obj = {
                property_id:$scope.id,
                review:rv,
                rating:rt,
                token:$window.localStorage.token
            }
            $http.post(URL_ADD_REVIEW,obj)
                .success(function(res){
                    $log.log(res);
                    prompt({title:"Success",
                			message:"Your review was sent successfully.",
                			buttons:[
                				{
                					"label":"Dismiss",
                					"cancel":false,
                					"primary":true
                				}
                			]
                		});
                    $timeout(function(){
                    	resetReview();
                    	//collect response from server and update current review
                    	for(var i = 0;i < $scope.reviewArray.length;i++){
                    		if($scope.reviewArray[i].review_id == res.review_id){
	                    		$scope.reviewArray[i].rating = res.rating;
	                    		$scope.reviewArray[i].review = res.review;
	                    		$scope.reviewArray[i].first_name = res.first_name;
	                    		$scope.reviewArray[i].last_name = res.last_name;
	                    		$scope.reviewArray[i].modified_time = res.modified_time;
	                    	}
                    	}	

                    });
                    
                    $log.log($scope.reviewArray);
                    
                	// $timeout(function(){
                	// 	var d = new Date();
                	// 	var obj = {
                	// 		first_name:$rootScope.currentUser.fname,
                	// 		lastname:$rootScope.currentUser.lname,
                	// 		rating:rt,
                	// 		review:rv,
                	// 		modified_time:d.toString()
                	// 	}
                	// 	$scope.reviewArray.push(obj);
                	// 	resetReview();
                	// 	$log.log("review text=>"+$scope.reviewText);
                	// });
                })
                .error(function(res){$log.log(res)});
        }

    });

    app.controller('PropertyController',function($scope,$window,$log,$http,$state,$timeout){

        $scope.property = {
            events:[]
        };

        $scope.canBid = false;


        if($state.params.id !== null && $state.params.id !== ''){

            $scope.id = $state.params.id;
            $scope.name = $state.params.name;
            var token = "";
            if($window.localStorage.token){
            	token = "&token="+$window.localStorage.token;
            }

            $http.get(URL_LISTING+"/"+$scope.id+token).success(function(data){
                if(!data.error){
                    $scope.property = data.property;
                    var s = $scope.property.name;
                    $scope.property.other_name = s.replace(/ /g,'-');
                    //sample events
                    //$scope.property.events = [{"date":"2015-05-24","badge":false,"title":"test","classname":"legend-bid"}];
                    if($scope.property.events){
                        $.each($scope.property.events, function(index, val) {
                            if(val.status == "accepted"){
                                val.classname = "legend-book";
                            }else if(val.status == "in_progress" && val.type == "book"){
                                val.classname = "legend-default";
                            }
                            else if(val.status == "in_progress" && val.type == "bid") {
                                val.classname = "legend-bid";
                            }else if(val.status == "closed" && val.type == "book"){
                                val.classname = "legend-book";
                            }else if(val.status == "closed" && val.type == "own"){
                                val.classname = "legend-book";
                            }else if(val.status == "cancelled"){
                                val.classname = "legend-default";
                            }
                        });
                    }else{
                        $scope.property.events = [];
                    }
                    // if($scope.property.longitude == (""|undefined)){
                    // 	$scope.property.longitude = 3.3762144701172474 ;
                    // 	$scope.property.latitude = 6.521614976011099 ;
                    // }
                }
                $log.log(data);
            }).error(function(data){
                $log.log(data);
            });


        }else{
            //show prompt saying property id is incorrect and redirect to listing
            $log.log("stateparam.id =>"+$state.params.id);
        }

        $scope.changeImage = function(index){
            if($scope.property.images.length > index){
                var imageHolder = angular.element('#propertyImage');
                imageHolder.fadeOut('fast', function() {
                    imageHolder.attr('src',$scope.property.images[index].src);
                    imageHolder.fadeIn('fast');
                });

            }
        }

        // $scope.$watch(function(scope){return $scope.property.events}, function(newval){
        // 	var count = 0;
        // 	angular.forEach($scope.property.events,function(element, index){
        // 		if(element.flag == "add"){
        // 			count++;
        // 		}
        // 	});	
        // 	if(count > 0){
        // 		$scope.canBid = true;
        // 	}
        // 	$log.log("canBid "+$scope.canBid);
        // });

        $scope.bidOrbook = function(){
            //$log.log($scope.property.events);
            angular.forEach($scope.property.events,function(element, index){
                if(element.flag == "add"){
                    $state.go("bidbook",{property_name:$scope.property.other_name,id:$scope.property.property_id,date:element.date});
                }
            });
        }


    })

    app.controller('FeaturedController',function($scope,$window,$log,$http){

        $http.get(URL_LATEST).success(function(data){
            arr = data.latest;
            $.each(arr, function(index, val) {
                var s = val.name;
                var d = val.description;
                if(d.length >= MAX_TEXT){
                    val.short_description = d.substr(0,MAX_TEXT)+"...";
                }else{
                    val.short_description = d;
                }
                val.other_name = s.replace(' ','-');
            });
            $log.log(arr);
            $scope.propertyList = arr;
            $scope.$watch($scope.propertyList, function() {
                $('.masonry .item').each(function() {
                    $(this).imagesLoaded(function () {
                        $('.masonry').masonry();
                        console.log('done');
                    });
                });
            });
        }).error(function(data){
            $log.log(data);
        });
    });


    app.controller('BidBookController',function($scope, $http, $log,$state,$window,$timeout, dateFilter, $interval, prompt){

   //  	$scope.property = {};

   //  	$scope.bid = {};

   //  	$scope.bid.price;
   //  	var timer;


   //  	$scope.alterBid = function(status){
   //  		// if(status){
   //  		// 	$scope.bid.price = parseInt($scope.bid.price) + 5000;
   //  		// }else{
   //  		// 	var s = parseInt($scope.bid.price) - 5000;
   //  		// 	$log.log({
   //  		// 		s:s,
   //  		// 		bid:$scope.bid.price
   //  		// 	})
   //  		// 	if(s > (parseInt($scope.bid.price))){
   //  		// 		$scope.bid.price = s;
   //  		// 	}
    			
   //  		// }
   //  	}

   //  	var getCountdownOffset = function(date){
   //  		var d = new Date(date).getTime();
   //  		$log.log("date=>"+(new Date(date).toString()));
   //  		$scope.endTime = Math.round(d) + Math.round(HOURS_48_MILLI);
   //  		$log.log("endTime=>"+(new Date($scope.endTime).toString()));
   //  		//var interval= new Date().getTime() - Math.round(d);
   //  		//$log.log("interval=>"+interval);
   //  		//$scope.currentTime = Math.round($scope.endTime)-(interval);
   //  		//$log.log("current Time=>"+ (new Date($scope.currentTime)).toString()+" end time=>"+ (new Date($scope.endTime).toString()));
   //  	}

   //  	var updateTime = function(){
			// if((new Date().getTime()) < $scope.endTime){
			// 	//$scope.currentTimeString = dateFilter(new Date($scope.currentTime),"hh:mm:ss");
			// 	$scope.currentTimeString = printRemainingTime($scope.endTime - new Date().getTime());
			// }
			// //$log.log("End time=>"+$scope.endTime);
   //  	}

   //  	$scope.$watch('currentTime',function(newVal){
   //  		//$scope.currentTimeString = dateFilter(new Date(newVal),"hh:mm:ss");
   //  		if(newVal){
   //  			$scope.currentTimeString = printRemainingTime(newVal);
   //  			//$log.log("new current Time"+$scope.currentTimeString);	
   //  		}
    		
   //  	});

   //  	var printRemainingTime = function(milliseconds){
   //  		var second = milliseconds / 1000 ;
		 //    var seconds = Math.floor(second) %60;
		 //    var minutes =  Math.floor(second/60) % 60;
		 //    var hours = Math.floor(second/3600); 
		 //    //var mins = Math.floor((second % 3600) / 60);
		 //    //var sec = Math.floor(((second % 3600) % 60) / 60);

		 //    //$log.log(hours+":"+mins+":"+sec);
		 //    if(hours < 10 )
		 //    	hours = "0"+hours;
		 //    if(minutes < 10 )
		 //    	minutes = "0"+minutes;
		 //    if(seconds < 10 )
		 //    	seconds = "0"+seconds;

		 //    // hours =  hours<10 ? '0'+hours+':' : hours+':'; 
		 //    // result = hours<10 ? '0'+hours+':' : hours+':';      
		 //    // minutes += minutes<10 ? '0'+minutes+':' : minutes+':';
		 //    // seconds += seconds<10 ? '0'+seconds : seconds;
		 //    return (hours + " hour(s) " + minutes + " minute(s) " + seconds + " second(s)");
   //  	}

   //  	$scope.canBid = true;
   //  	$scope.canBook = true;

    	


   //  	if($state.params.id !== null && $state.params.id !== ''){
   //  		id = $state.params.id;
   //  		$scope.bid.date = $state.params.date;
   //  		var d = $state.params.date.split('-');
   //  		var dd = new Date(d[0],(d[1]-1),d[2]);
   //  		$scope.bid.dateString = WEEK_DAYS[dd.getDay()]+"  "+MONTHS[dd.getMonth()]+" "+dd.getDate()+",  "+dd.getFullYear();
   //  		var obj = {
   //  			property_id:id,
   //  			date:$scope.bid.date,

   //  		}
   //  		$http.get(URL_DATE_DETAILS+"?property_id="+id+"&date="+$scope.bid.date+"&token="+$window.localStorage.token).success(function(data){
   //  			if(!data.error){
   //  				$scope.property = data.details;

   //  				if(($scope.property.book_status == "accepted") || ($scope.property.book_status == "closed")){
   //  					$scope.canBook = false;
   //  					prompt({title:"Alert!!",
	  //   					message:"Sorry this property is Unavailable for this date.",
	  //   					buttons:[
	  //   								{
	  //   									"label":"Dismiss",
	  //   									"cancel":false,
	  //   									"primary":true
	  //   								}
	  //   							]
	  //   						}).then(function(result){
	  //   							$timeout(function(){
	  //   								$state.go('viewProperty',{id:parseInt($state.params.id),property_name:$state.params.property_name});	
	  //   							});
	  //   						},function(){
	  //   							$timeout(function(){
	  //   								$state.go('viewProperty',{id:parseInt($state.params.id),property_name:$state.params.property_name});	
	  //   							});
	  //   						});
	  //   			}else if($scope.property.bid_status == "closed"){
	  //   				$scope.canBid = false;	
	  //   			}else if($scope.property.owner){
	  //   				$scope.canBid = false;
	  //   				$scope.canBook = false;
	  //   			}else{
	  //   				$scope.canBid = true;
	  //   				$scope.canBook = true;
	  //   			};
    				

   //  				if(!$scope.property.bid.current_bid_price){
   //  					$scope.bid.price = $scope.property.min_bid_price;
   //  					$scope.property.bid = undefined;
   //  				}else{
   //  					$scope.bid.price = $scope.property.bid.current_bid_price;
   //  					getCountdownOffset($scope.property.bid.bid_start_time);
   //  					timer = $interval(function(){
   //  						$scope.currentTime = Math.round($scope.currentTime) - 1000;
   //  						updateTime();
   //  					},1000);
   //  				}

   //  				if($scope.property.bid){
   //  					$.each($scope.property.bid.races, function(index, val) {
			//         		 var s = val.created_time;
			//         		 // //val.timeString = dateFilter(new Date(s),"M/d/yy h:mm:ss a")
			//         		 // val.timeString = moment().format(s).fromNow();
			//         	});
   //  				}
    				

   //  				// sample events
			// 		// $scope.property.events = [
			// 		// 	{"date":"2015-05-24","badge":false,"title":"test","classname":"legend-bid"},
			// 		// 	{"date":"2015-05-14","badge":false,"title":"test","classname":"legend-book"}
			// 		// ];
   //  				// if($scope.property.longitude == (""|undefined)){
   //  				// 	$scope.property.longitude = 3.3762144701172474 ;
   //  				// 	$scope.property.latitude = 6.521614976011099 ;	
   //  				// }
   //  				// if($scope.property.events){
   //  				// 	$.each($scope.property.events, function(index, val) {
   //  				// 		 val.classname = "legend-book";
   //  				// 	});
   //  				// }else{
   //  				// 	$scope.property.events = [];
   //  				// }
   //  			}
   //  			$log.log(data);
   //  		}).error(function(data){
   //  			$log.log(data);
   //  		});
   //  	}else{
   //  		$log.log("stateparam.id =>"+$state.params.id);
   //  	}

   //  	var makeRequest = function(result,type){
   //  		$log.log(result);
   //  		if(result){
   //  			$http.post(URL_BID_BOOK, $scope.bid).success(function(data){
	  //   			$log.log(data);
	  //   			$timeout(function(){
	  //   				prompt({title:"Congratulations",
	  //   					message:type+" successful!! The property owner will contact you if he chooses to accept",
	  //   					buttons:[
	  //   								{
	  //   									"label":"Dismiss",
	  //   									"cancel":false,
	  //   									"primary":true
	  //   								}
	  //   							]
	  //   						}).then(function(result){
	  //   							$timeout(function(){
	  //   								$state.go('viewProperty',{id:parseInt($state.params.id),property_name:$state.params.property_name});	
	  //   							});
	  //   						});
		 //    		});
	  //   		}).error(function(data){$log.log(data)});
   //  		}
   //  	}


   //  	$scope.bidOrbook = function(type){
   //  		$scope.bid.type = type;
   //  		$scope.bid.property_id = $scope.property.property_id;
   //  		$scope.bid.token = $window.localStorage.token;
   //  		if($scope.bid.title){
   //  			prompt({title:"Confirmation",
   //  					message:"Are you sure you want to perform this action?",
   //  					buttons:[
   //  						{
   //  							"label":"No",
   //  							"cancel":true,
   //  							"primary":false
   //  						},
   //  						{
   //  							"label":"Yes",
   //  							"cancel":false,
   //  							"primary":true
   //  						}
   //  					]
   //  			}).then(function(result){
   //  				makeRequest(result,type);
   //  			});
    			
   //  		}
   //  	}

    	

   //  	$scope.$on('$destroy', function(event) {
   //  		if(timer)
   //  			$interval.cancel(timer);
   //  	});

        $scope.property = {};

        $scope.bid = {};

        $scope.bid.price;
        var timer;


        $scope.alterBid = function(status){
            if(status){
                $scope.bid.price = parseInt($scope.bid.price) + 5000;
            }else{
                s = parseInt($scope.bid.price) - 5000;
                if(!$scope.property.bid){
                	if(s >= (parseInt($scope.property.min_bid_price)))
                    	$scope.bid.price = s;
                }else{
                	if(s >= (parseInt($scope.property.bid.current_bid_price)))
                    	$scope.bid.price = s;
                }
                

            }
        }

        var getCountdownOffset = function(date){
            var d = new Date(date).getTime();
            $log.log("date=>"+(new Date(date).toString()));
            $scope.endTime = Math.round(d) + Math.round(HOURS_48_MILLI);
            $log.log("endTime=>"+(new Date($scope.endTime).toString()));
            //var interval= new Date().getTime() - Math.round(d);
            //$log.log("interval=>"+interval);
            //$scope.currentTime = Math.round($scope.endTime)-(interval);
            //$log.log("current Time=>"+ (new Date($scope.currentTime)).toString()+" end time=>"+ (new Date($scope.endTime).toString()));
        }

        var updateTime = function(){
            if((new Date().getTime()) < $scope.endTime){
                //$scope.currentTimeString = dateFilter(new Date($scope.currentTime),"hh:mm:ss");
                $scope.currentTimeString = printRemainingTime($scope.endTime - new Date().getTime());
            }
            //$log.log("End time=>"+$scope.endTime);
        }

        $scope.$watch('currentTime',function(newVal){
            //$scope.currentTimeString = dateFilter(new Date(newVal),"hh:mm:ss");
            if(newVal){
                $scope.currentTimeString = printRemainingTime(newVal);
                //$log.log("new current Time"+$scope.currentTimeString);
            }

        });

        var printRemainingTime = function(milliseconds){
            var second = milliseconds / 1000 ;
            var seconds = Math.floor(second) %60;
            var minutes =  Math.floor(second/60) % 60;
            var hours = Math.floor(second/3600);
            //var mins = Math.floor((second % 3600) / 60);
            //var sec = Math.floor(((second % 3600) % 60) / 60);

            //$log.log(hours+":"+mins+":"+sec);
            if(hours < 10 )
                hours = "0"+hours;
            if(minutes < 10 )
                minutes = "0"+minutes;
            if(seconds < 10 )
                seconds = "0"+seconds;

            // hours =  hours<10 ? '0'+hours+':' : hours+':';
            // result = hours<10 ? '0'+hours+':' : hours+':';
            // minutes += minutes<10 ? '0'+minutes+':' : minutes+':';
            // seconds += seconds<10 ? '0'+seconds : seconds;
            return (hours + " hour(s) " + minutes + " minute(s) " + seconds + " second(s)");
        }

        $scope.canBid = true;
        $scope.canBook = true;




        if($state.params.id !== null && $state.params.id !== ''){
            id = $state.params.id;
            $scope.bid.date = $state.params.date;
            var d = $state.params.date.split('-');
            var dd = new Date(d[0],(d[1]-1),d[2]);
            $scope.bid.dateString = WEEK_DAYS[dd.getDay()]+"  "+MONTHS[dd.getMonth()]+" "+dd.getDate()+",  "+dd.getFullYear();
            var obj = {
                property_id:id,
                date:$scope.bid.date,

            }
            $http.get(URL_DATE_DETAILS+"?property_id="+id+"&date="+$scope.bid.date+"&token="+$window.localStorage.token).success(function(data){
                if(!data.error){
                    $scope.property = data.details;

                    if(($scope.property.book_status == "accepted") || ($scope.property.book_status == "closed")){
                        $scope.canBook = false;
                        prompt({title:"Alert!!",
                            message:"Sorry this property is Unavailable for this date.",
                            buttons:[
                                {
                                    "label":"Dismiss",
                                    "cancel":false,
                                    "primary":true
                                }
                            ]
                        }).then(function(result){
                            $timeout(function(){
                                $state.go('viewProperty',{id:parseInt($state.params.id),property_name:$state.params.property_name});
                            });
                        },function(){
                        	$timeout(function(){
                                $state.go('viewProperty',{id:parseInt($state.params.id),property_name:$state.params.property_name});
                            });
                        });
                    }else if($scope.property.bid_status == "closed"){
                        $scope.canBid = false;
                    }else if($scope.property.owner){
                        $scope.canBid = false;
                        $scope.canBook = false;
                    }else{
                        $scope.canBid = true;
                        $scope.canBook = true;
                    };


                    if(!$scope.property.bid.current_bid_price){
                        $scope.bid.price = $scope.property.min_bid_price;
                        $scope.property.bid = undefined;
                    }else{
                        $scope.bid.price = $scope.property.bid.current_bid_price;
                        getCountdownOffset($scope.property.bid.bid_start_time);
                        timer = $interval(function(){
                            $scope.currentTime = Math.round($scope.currentTime) - 1000;
                            updateTime();
                        },1000);
                    }

                    if($scope.property.bid){
                        $.each($scope.property.bid.races, function(index, val) {
                            var s = val.created_time;
                            // //val.timeString = dateFilter(new Date(s),"M/d/yy h:mm:ss a")
                            // val.timeString = moment().format(s).fromNow();
                        });
                    }


                    // sample events
                    // $scope.property.events = [
                    // 	{"date":"2015-05-24","badge":false,"title":"test","classname":"legend-bid"},
                    // 	{"date":"2015-05-14","badge":false,"title":"test","classname":"legend-book"}
                    // ];
                    // if($scope.property.longitude == (""|undefined)){
                    // 	$scope.property.longitude = 3.3762144701172474 ;
                    // 	$scope.property.latitude = 6.521614976011099 ;
                    // }
                    // if($scope.property.events){
                    // 	$.each($scope.property.events, function(index, val) {
                    // 		 val.classname = "legend-book";
                    // 	});
                    // }else{
                    // 	$scope.property.events = [];
                    // }
                }
                $log.log(data);
            }).error(function(data){
                $log.log(data);
            });
        }else{
            $log.log("stateparam.id =>"+$state.params.id);
        }


        $scope.bidOrbook = function(type){
            $scope.bid.type = type;
            $scope.bid.property_id = $scope.property.property_id;
            $scope.bid.token = $window.localStorage.token;
            if($scope.bid.title){
                $http.post(URL_BID_BOOK, $scope.bid).success(function(data){
                    $log.log(data);
                    $timeout(function(){
                        prompt({title:"Congratulations",
                            message:type+" successful!! The property owner will contact you if he chooses to accept",
                            buttons:[
                                {
                                    "label":"Dismiss",
                                    "cancel":false,
                                    "primary":true
                                }
                            ]
                        }).then(function(result){
                            $timeout(function(){
                                $state.go('viewProperty',{id:parseInt($state.params.id),property_name:$state.params.property_name});
                            })
                        });
                    });
                }).error(function(data){$log.log(data)});
            }
        }

        $scope.$on('$destroy', function(event) {
            if(timer)
                $interval.cancel(timer);
        });

    });


    app.controller('NotificationController',function($scope,$log,$http,$window,$interval,$state,$timeout){
        var marker;

        var notificationCaller = $interval(function(){
            getNotifications();
            //$log.log($scope.notificationArray);
        },NOTIFICATION_INTERVAL);

        $scope.notificationArray = [];

        $scope.disableNotiLoadMore = false;


        var createNotification = function(id,sid,type,pname,uname,img,date){
        	var msg = "";
        	switch(type){
        		case "bid":
        			msg = uname+" just placed a bid on this property";
        			break;
        		case "book":
        			msg = uname+" just placed a booking on this property";
        			break;
        		case "bid_accepted":
        			msg = "Your bid has been accepted";
        			break;
        		case "bid_declined":
        			msg = "Your bid has been declined";
        			break;
        		case "book_accepted":
        			msg = "Your booking has been accepted";
        			break;
        		case "book_closed":
        			msg = "Bidding for this property has ended.";
        			break;
        		case "book_declined":
        			msg = "Your booking has been declined";
        			break;
				case "review":
					msg = uname+" just reviewed your property";        			
					break;
				case "payment_accepted":
					msg = "The property owner just accepted your payment";
					break;
                case "payment_cancelled":
                    msg = "You cancelled your payment for this property";
                    break;
                case "payment_cancelled_owner":
                    msg = "The Client has cancelled his/her payment for this property. ";
                    break;
				case "bid_accepted_owner":
        			msg = "You just accepted a bid";
        			break;
        		case "bid_declined_owner":
        			msg = "You just declined a bid";
        			break;
        		case "book_accepted_owner":
        			msg = "You just accepted a booking";
        			break;
        		case "book_declined_owner":
        			msg = "You just declined a booking";
        			break;
        	}

            var noti = {
                id:id,
                s_id:sid,
                type:type,
                property_name:pname,
                user_name:uname,
                property_image:img,
                date:date,
                message:msg
            }
            return noti;
        }

        var getNotifications = function(){
            var marker;
            if($scope.notificationArray.length > 0)
                marker = $scope.notificationArray[0].id;
            var extra = "";
            if(marker)
                extra = "&type=newer&marker="+marker;
            $http.get(URL_NOTIFICATIONS+"?token="+$window.localStorage.token+extra).success(function(res){
            	//$log.log(res);
                var arr = res.notifications;
                var c = 0;
                for(var i = arr.length-1; i >= 0; i--){
                    var val = arr[i];
                    if(val.property){
                        var s = val.property.name.replace(/['"]+/g, '');
                    	var a = createNotification(val.notification_id,val.subject_id,val.type,s,val.details.user_name,"",val.created_time);	
                    }else{
                        var s = val.property.name.replace(/['"]+/g, '');
                    	var a = createNotification(val.notification_id,val.subject_id,val.type,"","","",val.created_time);
                    }
                    
                    //5 notifications per page
                    if(c<= 4){
                    	$scope.notificationArray.splice(0,0,a);
                    }else{
                    	break;
                    }
                    c++;
                }
            });
        }

        var getOldNotifications = function(){
        	var marker = $scope.notificationArray[$scope.notificationArray.length - 1].id;
        	var extra = "&type=older&marker="+marker;
        	$http.get(URL_NOTIFICATIONS+"?token="+$window.localStorage.token+extra).success(function(res){
                var arr = res.notifications;
                if(arr.length > 0){
                	for(var i = 0; i < arr.length; i++){
	                    var val = arr[i];
	                    if(val.property){
                            var s = val.property.name.replace(/['"]+/g, '');
	                    	var a = createNotification(val.notification_id,val.subject_id,val.type,val.property.name,val.details.user_name,"",val.created_time);	
	                    }else{
                            var s = val.property.name.replace(/['"]+/g, '');
	                    	var a = createNotification(val.notification_id,val.subject_id,val.type,"","","",val.created_time);
	                    }
	                    if(i <= 4){
	                    	$scope.notificationArray.push(a);
	                    }else{
	                    	break;
	                    }
	                }
                }else{
                	$scope.disableNotiLoadMore = true;
                }
                
            });
            //$log.log($scope.notificationArray);
        }

        $scope.moreNotifications = function(){
        	getOldNotifications();
        }

        $scope.selectNotification = function(){
            $timeout(function(){
                $state.go('profile',{openNotification:true});
            });
        }

        getNotifications();

        $scope.$on('$destroy',function(){$interval.cancel(notificationCaller);});
    });

	app.controller('PayController',function($scope,$state,$http,$log,$timeout,$window,prompt){
		$scope.property = {};
		$scope.details = {};
		$scope.payment = {};
		$scope.canPay = false;

		if($state.params.bid_book_id){
			var obj = {
				bid_book_id:$state.params.bid_book_id,
				token:$window.localStorage.token
			}
			$http.post(URL_GET_PAYMENT_INFO,obj)
			.success(function(res){
				console.log(res)
				if(!res.error){
					$scope.property = res.property;
					$scope.details = res.details;
					$scope.payment = res.payment;

					if($scope.details.payment_status == "unpaid"){
						$scope.canPay = true;
					}else{
						prompt({title:"Attention!",
							message:"You've already paid for this property.",
	                        buttons:[
	                        	{
	                                "label":"Dismiss",
	                                "cancel":false,
	                                "primary":true
	                            }
	                        ]
						});
					}

				}else{
					prompt({title:"Warning!",
							message:"Invalid Transaction.",
	                        buttons:[
	                        	{
	                                "label":"Dismiss",
	                                "cancel":false,
	                                "primary":true
	                            }
	                        ]
						}).then(function(res){
							$state.go("listing");
						},function(){
							$state.go("listing");
						});
				}
			})
			.error(function(res){
				$log.log(res)
			});
		}
	});


	app.directive('payForm',function($timeout,prompt){
	    return {
	        restrict:'E',
	        template:'<p><button class="btn btn-primary btn-block" ng-click="SubmitForm()">Continue</button></p>',
	        scope:{
	            formData:'=data'
	        },
	        link:function(scope,elem,attrs){
	            scope.SubmitForm = function(){
	            	var pay = scope.formData;
	            	if(pay.paymenttype != undefined){
	            		elem.append('<form action="'+pay.gatewayurl+'" method="POST">'+
		                  '<input type="hidden" ng-name="{{key}}" ng-value="{{val}}" />'+
		                    '<input id="merchantId" name="merchantId" value="'+pay.merchantId+'" type="hidden"/>'+
		                    '<input id="rrr" name="rrr" value="'+pay.rrr+'" type="hidden"/>'+
		                    '<input id="responseurl" name="responseurl" value="'+pay.responseurl+'" type="hidden"/>'+
		                    '<input id="hash" name="hash" value="'+pay.hash+'" type="hidden"/>'+
		                    '<input id="hash" name="paymenttype" value="'+pay.paymenttype+'" type="hidden"/>'+
		              '</form>');
		                // console.log(scope.formData);
		                // console.log(pay);
		                $timeout(function(){
		                    elem.find('form').submit().remove();    
		                });
	            	}else{
	            		prompt({title:"Attention!!",
	            				message:"Please select a card type from the options provided in the dropdown.",
	            				buttons:[
	            					{
	            						"label":"Dismiss",
	            						"primary":true,
	            						"cancel":false
	            					}
	            				]
	            			});
	            	}
	            }
	        }
	    }

	});


})();