var selected_color   = "rgb(50, 80, 140)";
var unselected_color = "rgb(56, 121, 241)";
var current_selected;
$(document).ready(function() {
    if(window.location.pathname=='/consulting.php'){
        var materials_development = document.getElementById("materials_development");
        var battery_prototyping   = document.getElementById("battery_prototyping");
        var battery_production    = document.getElementById("battery_production");
        var ip_and_swot           = document.getElementById("ip_and_swot");
        var investing             = document.getElementById("investing");
        var human_resources       = document.getElementById("human_resources");
        var service_text_box      = document.getElementById("service_text_box");
        const selection_list = [
                                materials_development, 
                                battery_prototyping,
                                battery_production, 
                                ip_and_swot, 
                                investing, 
                                human_resources
                                ];
        /*if no boxes are selected, select materials_development  assign the correspoding text, and update current selected element*/
        if(!(checkIfSelected(selection_list))){
            selectItem(materials_development);
            clearList(service_text_box);
            service_text_box.innerHTML = buildHTMLString(materials_development);
        }
        /*add event listener for a click to each item with function call when element is selected*/
        selection_list.forEach(function(element){
           element.addEventListener("click", function(){whenClicked(element)});
        });
         /*when element is selected, deselect current element, select the element chosen, clear textbox, and set text*/
        function whenClicked(element){
            /*deselect all  elements*/
            deSelectItem(current_selected);
        
            /*select element chosen*/
            selectItem(element);
            clearList(service_text_box);
            service_text_box.innerHTML = buildHTMLString(element);
        }
    }
});
/*function to clear all selected items*/
function clearList(list){
    while(list.firstChild){
        list.removeChild (list.firstChild);
    }
}
/*function to select item from list*/
function selectItem(element){
    element.style.backgroundColor = selected_color;
    current_selected = element;
}
/*function to un-select item from list */
function deSelectItem(element){
    element.style.backgroundColor = unselected_color;
}
/*function to check if item is selecetd */
function checkIfSelected(list){
    list.forEach(function(element){
        if (element.style.backgroundColor == unselected_color){
            return true;
        }
    });
    return false;

}
/*function to build output string to display in html*/
function buildHTMLString(name){
    var str = "<ul>"
    switch(name){
        case materials_development:
            str += "<li>We develop detailed plans for characterization of materials. " +
                   "These plans include detailed methodologies, required equipment, suppliers of materials, experimental design and setup.</li>";
            str += "<li>We provide in-depth experise in electrochemistry.</li>";                   
            str += "<li>We analyze experimental data and provide a view on patentability and IP strategy.</li>";
            str += "<li>We develop workflow from material to final cell design.</li>";
            str += "<li>We provide custom solutions for your needs.</li>";
            break;
        case battery_prototyping:
            str += "<li>We review existing cell designs and recommend improvements.</li>";
            str += "<li>We construct detailed product development plans with design spreadsheets, and a workflow from prototype to pilot line production.</li>";
            str += "<li>We provide confidential, technical opinions and review drafts of planned patent applications and publications in scientific magazines.</li>";
            str += "<li>We provide custom solutions for your needs.</li>";
            break;
        case battery_production:
            str += "<li>We assess products.</li>"; 
            str += "<li>We conduct troubleshooting.</li>";
            str += "<li>We conduct FMEA and perform Root Cause Analysis.</li>";
            str += "<li>We provide custom solutions for your needs.</li>";
            break;
        case ip_and_swot:
            str += "<li>We analyze patent portfolios.</li>";
            str += "<li>We develop IP strategies.</li>"
            str += "<li>We review patents and patent applications and provide technical opinions.</li>";
            str += "<li>We provide strategic planning by identifying strengths, weaknesses, opportunities, and threats (SWOT analysis) related to battery products.</li>";
            str += "<li>We serve as a technology expert witnesses.</li>";
            str += "<li>We provide custom solutions for your needs.</li>";
            break;
        case investing:
            str += "<li>We provide independent and confidential technical evaluations for your current and future investments.</li>";
            str += "<li>We identify strengths, weaknesses, opportunities, and threats (SWOT analysis) of battery technologies related to your current and future investments.</li>";
            str += "<li>We provide custom solutions for your needs.</li>";
            break;
        case human_resources:
            str += "<li>If you are in the process of hiring personnel, we interview engineers, scientists, and technicians.</li>";
            str += "<li>We provide custom solutions for your needs.</li>";
            break;
    }
    return (str += "</ul>");
}