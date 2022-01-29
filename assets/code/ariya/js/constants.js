(function(){

    this.MAX_TEXT = 100;

    this.WORLD_COUNTRIES = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Democratic Republic of Congo", "Republic of the Congo", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Mongolia", "Morocco", "Monaco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Samoa", "San Marino", " Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"];

    this.PROPERTY_CATEGORIES = ['Halls','Office','Rooftop','Compound','Garden','Conference Room'];
    this.STAR_RATINGS = ['0','10','20','30','40','50','60','70','80','90','100'];

    this.WEEK_DAYS = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    this.MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    this.HOURS_48_MILLI = 172800000;
    this.HOURS_24_MILLI = 86400000;

    this.NOTIFICATION_INTERVAL = 30000;


	this.BASE_URL_LOCAL = "http://localhost/ariya/api/v1";
    if((location.href).indexOf('ariya.') == -1){
        this.BASE_URL_SERVER = "http://code.caleb.com.ng/ariya/api/v1";
    }
    else{
        this.BASE_URL_SERVER = "http://ariya.ng/api/v1";
    }
    this.BASE_URL_SERVER_WWW = "http://www.ariya.ng/api/v1";

    if(((location.href).indexOf('localhost') == -1) && ((location.href).indexOf('www.') == -1)){
        this.isLocal = false;
        this.isWWW = false;
    }
    else if((location.href).indexOf('www.') == -1){
        this.isLocal = true;
        this.isWWW = false;
    }
    else if((location.href).indexOf('localhost') == -1){
        this.isLocal = false;
        this.isWWW = true;
    }
    else{
        this.isLocal = true;
        this.isWWW = true;
    }
	this.BASE_URL = "";
    if(isWWW && !isLocal){
        BASE_URL = BASE_URL_SERVER_WWW
    }
	else if(!isWWW & isLocal){
		BASE_URL = BASE_URL_LOCAL;
	}else{
		BASE_URL = BASE_URL_SERVER;
	}
	this.URL_LOGIN = BASE_URL+"/login";
	this.URL_REGISTER = BASE_URL+"/register";
	this.URL_EDIT_PROFILE = BASE_URL+"/editprofile";
	this.URL_GET_PROFILE = BASE_URL+"/getprofile";
	this.URL_FORGOT_PASSWORD = BASE_URL+"/forgotpassword";
	this.URL_CHANGE_PASSWORD = BASE_URL+"/changepassword";
	this.URL_ADD_PROPERTY = BASE_URL+"/addeditproperty";
	this.URL_MY_PROPERTIES = BASE_URL+"/myproperties";
	this.URL_GET_MY_PROPERTY = BASE_URL+"/getmyproperty";
    this.URL_ADD_PROPERTY_IMAGE = BASE_URL+"/addpropertyimage";
    this.URL_DELETE_IMAGE = BASE_URL+"/deletepropertyimage"; //property_id,image_id,token
    this.URL_DELETE_PROPERTY = BASE_URL+"/deleteproperty"; //property_id,token
    this.URL_LISTING = BASE_URL+"/listing";
    this.URL_LATEST = BASE_URL+"/latestSix";
    this.URL_ADD_EVENT = BASE_URL+"/addevent"; //property_id,title,date,token
    this.URL_REMOVE_EVENT = BASE_URL+"/removeevent"; //property_id,event_id,token
    this.URL_BID_BOOK = BASE_URL+"/bidbook"; //property_id,date,price,title,type,token
    this.URL_DATE_DETAILS = BASE_URL+"/datedetails"; //property_id,date,token
    this.URL_NOTIFICATIONS = BASE_URL+"/notifications";//token
    this.URL_NOTIFICATION_ACTION = BASE_URL+"/notificationaction" //token, notification_id, status(accepted/declined)
    this.URL_ADD_REVIEW = BASE_URL+"/addreview"//token,property_id,review,rating
    this.URL_GET_REVIEW = BASE_URL+"/getreview"
    this.URL_SEARCH = BASE_URL+"/search";//query,type,rating,feature
    this.URL_GET_PAYMENT_INFO = BASE_URL+"/pay";//bid_book_id,token
    this.URL_CANCEL_PAYMENT = BASE_URL+"/cancelpayment";//notification_id,token
})();