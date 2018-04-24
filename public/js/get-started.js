function salary()
{
    var salaryTotal=0;
    //Get a reference to the form id="teacherform"
    var theForm = document.forms["teacherform"];
    //Get a reference to the select id="salary"
    var salary = theForm.elements["salary"];
     
    //set salaryTotal equal to value user chose
    //For example filling_prices["Lemon".value] would be equal to 5
    salaryTotal = salary.value;

    //finally we return salaryTotal
    return salaryTotal;
}

function hourly()
{
    var hourlyTotal=0;
    var theForm = document.forms["teacherform"];
    var hourly = theForm.elements["hourly"];
     
    hourlyTotal = hourly.value;

    return hourlyTotal;
}

function numStudents()
{
    var numStudentsTotal=0;
    var theForm = document.forms["teacherform"];
    var numStudents = theForm.elements["numStudents"];
     
    numStudentsTotal = numStudents.value;

    return numStudentsTotal;
}

function totalHour()
{
    var totalHourTotal=0;
    var theForm = document.forms["teacherform"];
    var totalHour = theForm.elements["totalHour"];
     
    totalHourTotal = totalHour.value;

    return totalHourTotal;
}

function calculateTotal()
{
    //Here we get the total price by calling our function
    //Each function returns a number so by calling them we add the values they return together
    var teacherClassrr = hourly() * numStudents() * totalHour() - salary();
    
    //display the result
    var divobj = document.getElementById('totalPrice');
    divobj.innerHTML = "<strong style='color:green'>$"+teacherClassrr+"</strong>";

}

function semester()
{
    var semesterTotal=0;
    var theForm = document.forms["studentform"];
    var semester = theForm.elements["semester"];
     
    semesterTotal = semester.value;

    return semesterTotal;
}

function classPrice()
{
    var classPriceTotal=0;
    var theForm = document.forms["studentform"];
    var classPrice = theForm.elements["classPrice"];
     
    classPriceTotal = classPrice.value;

    return classPriceTotal;
}

 var class_duration = new Array();
 class_duration["class1"]=6;
 class_duration["class3"]=2;

function classDur()
{  
    var classDur=0;
    var theForm = document.forms["studentform"];
    var selectedclassDur = theForm.elements["selectedclassDur"];
    for(var i = 0; i < selectedclassDur.length; i++)
    {
        if(selectedclassDur[i].checked)
        {
            classDur = class_duration[selectedclassDur[i].value];
            break;
        }
    }
    return classDur;
}

function calculateTotal2()
{
    //Here we get the total price by calling our function
    //Each function returns a number so by calling them we add the values they return together
    var studentClassrr = semester() - classPrice() * classDur();
    
    //display the result
    var divobj = document.getElementById('totalPrice2');
    divobj.innerHTML = "<strong style='color:green'>$"+studentClassrr+"</strong>";

}