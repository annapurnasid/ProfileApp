
$( document ).ready(function(){

        var paginationCtrls = "";
                
        // Only if there is more than 1 page worth of results give the user pagination controls
        if(1 !== pageCount){
            if (pn > 1) {
                paginationCtrls += '<button onclick="updatePn(' + (pn-1) + ')">&lt</button>';
            }
            paginationCtrls += ' &nbsp; &nbsp; <b>Page '+ pn +' of '+ pageCount +'</b> &nbsp; &nbsp; ';
            if (pn !== pageCount) {
                paginationCtrls += '<button onclick="updatePn(' + (pn+1) + ')" style="height: 30px;\n\
                width: 30px">&gt</button>';
            }
        }
        
        $("#paginationControls").html(paginationCtrls);
                
        $.ajax({
            url: 'pagination.php', 
            dataType : 'html',
            type : 'POST',
            data : {
                'pageNo' : pn,
                'totalPage' : pageCount,
            },
            success : function(data){
                resultHTML(data);
            }
        });
    
    $('#searchButton').on('click', function() {
        var name = $('#nameSearch').val();

        $.ajax({
            url: 'searchEmployee.php', 
            dataType : 'html',
            type : 'POST',
            data : {
                'name' : name,
                'search' : true
            },
            success : function(data){
                resultHTML(data);
            }
        });
    });
    
});

function updatePn(pageNo){
    pn = pageNo;
}

function resultHTML(data) {
    var resultSearch = JSON.parse(data);
    var html = '';
    html += '<table class="table table-responsive" id="display"><thead><tr><th>Serial No.</th>\n\
            <th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Date of Birth</th>\n\
            <th>Office Address</th><th>Residential Address</th>\n\<th>Marital  Status</th>\n\
            <th>Employement Status</th><th>Employer</th><th>Communication</th><th>Image</th>\n\
            <th>Note</th><th>Edit</th><th>Delete</th></tr></thead><tbody id="employeeListTableBody">'
                
    if (0 !== resultSearch.length) {
        var i = 1;
        resultSearch.forEach(function(object){
            html += '<tr>';
            for(var key in object) {

                html += '<td>';
                if ('EmpID' === key)
                {
                   html += i;
                }
                else
                {
                    html += object[key];
                }

                html += '</td>';
            }
            html += '<td>';
            
            if ( id == object['EmpID'])
            { 
                html += '<a href="registration.php"><span  class="glyphicon glyphicon-pencil"></span></a>';
            }
            
            html += '</td>';

            // Delete graphic-->
            html += '<td><a href="list.php?delete=' + object['EmpID'] + '"><span \n\
                class="glyphicon glyphicon-remove"></span></a></td>';

            html += '</tr>';
            i++;
        });

        html += '</tbody></table>';
        $("#display").html(html);
    }
    else {
        html = '<h1>Sorry! No result found</h1>';
        $("#display").html(html);
    }
}