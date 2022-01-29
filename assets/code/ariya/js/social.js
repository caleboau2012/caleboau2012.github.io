/**
 * Created by caleb on 4/27/15.
 */
function facebookShare(){
    var url="https://www.facebook.com/sharer/sharer.php?u=" + location.href;
    //console.log(url);
    window.open(url,"","toolbar=no,status=no,menubar=no,location=center,scrollbars=no,resizable=no,height=500,width=657");
}

function googlePlusShare(){
    var url="https://plus.google.com/share?url=" + location.href;
    //console.log(url);
    window.open(url,"","toolbar=no,status=no,menubar=no,location=center,scrollbars=no,resizable=no,height=500,width=657");
}

function twitterShare(){
    var data="https://twitter.com/home?status=View%20this%20awesome%20property%20on%20%40ariyainfo%0A%0A" + location.href;
    //console.log(data);
    window.open(data,"","toolbar=no,status=no,menubar=no,location=center,scrollbars=no,resizable=no,height=500,width=657");
}