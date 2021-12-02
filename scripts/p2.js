window.onload = function() {
    var submit=document.getElementById("submit");
    submit.addEventListener("click", validate);
    
    function validate(){
        console.log("clicked")
        var clerk=document.querySelector("#clerk").value.trim();
        var constit=document.querySelector("#constit").value.trim();
        var pollID=document.querySelector("#pollID").value.trim();
        var pollSt=document.querySelector("#pollSt").value.trim();
        var cand1=document.querySelector("#cand1").value.trim();
        var cand2=document.querySelector("#cand2").value.trim();
        var rejected=document.querySelector("#rejected").value.trim();
        var total=document.querySelector("#total").value.trim();
        //console.log(pollID,pollSt,cand1,cand2,rejected,total);
       
        var numbers= /^[0-9]+$/;
        var alpha= /^[A-Z0-9]+$/;
        
        if (!(clerk.match(numbers)) || clerk==""){
            console.log("no");
            document.getElementById("clerk").style.borderColor="red";
            return false;
        }else{
            document.getElementById("clerk").style.borderColor="black";
        }

        if (!(constit.match(numbers)) || constit==""){
            console.log("no");
            document.getElementById("constit").style.borderColor="red";
            return false;
        }else{
            document.getElementById("constit").style.borderColor="black";
        }

        if (!(pollID.match(numbers)) || pollID==""){
            console.log("no");
            document.getElementById("pollID").style.borderColor="red";
            return false;
        }else{
            document.getElementById("pollID").style.borderColor="black";
        }
        
        if (!(pollSt.match(alpha)) || pollSt==""){
            console.log("no");
            document.getElementById("pollSt").style.borderColor="red";
            return false;
        }else{
            document.getElementById("pollSt").style.borderColor="black";
        }

        if (!(cand1.match(numbers)) || cand1==""){
            console.log("no");
            document.getElementById("cand1").style.borderColor="red";
            return false;
        }else{
            document.getElementById("cand1").style.borderColor="black";
            n1=parseInt(cand1);
        }

        if (!(cand2.match(numbers)) || cand2==""){
            console.log("no");
            document.getElementById("cand2").style.borderColor="red";
            return false;
        }else{
            document.getElementById("cand2").style.borderColor="black";
            n2=parseInt(cand2);
        }

        if (!(rejected.match(numbers)) || rejected==""){
            console.log("no");
            document.getElementById("rejected").style.borderColor="red";
            return false;
        }else{
            document.getElementById("rejected").style.borderColor="black";
            n3=parseInt(rejected);
        }
        var sum=n1+n2+n3;
        console.log(sum);
        if (!(total.match(numbers)) || total==""){
            console.log("no");
            document.getElementById("total").style.borderColor="red";
            return false;
        }else if (parseInt(total) != sum){
            document.getElementById("total").style.borderColor="red";
        }else{
            document.getElementById("total").style.borderColor="black";
        }

        const htr= new XMLHttpRequest();
        htr.onreadystatechange = function(){
            if(this.readyState === XMLHttpRequest.DONE && this.status === 200){
                document.getElementById("form").innerHTML = this.responseText;
            }
        }
        htr.open("GET", "http://localhost/620140671/scripts/phpmysqlconnect.php?clerk="+clerk+"&constit="+constit+"&pollID="+pollID+"&pollSt="+pollSt+
        "&cand1="+cand1+"&cand2="+cand2+"&rejected="+rejected+"& total="+total);
        htr.send();
    }
}