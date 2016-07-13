/**
 * @Author  : Mfsi_Annapurnaa
 * @purpose : Perform Jquery operation
 */

$( document ).ready(function(){

    // Call Pagination ajax from server
    pagination(pageCount, pn);
    
    $('#searchButton').on('click', function() {
        var name = $('#nameSearch').val();

        $.ajax({
            url: 'searchPaginate.php', 
            dataType : 'html',
            type : 'POST',
            data : {
                'name' : name,
                'action' : 'search',
            },
            success : function(data){
                resultHTML(data);
            }
        });
    });
    
});

/**
* Function for executing pagination
*
* @access public
* @param  int pageCount
* @param  int pageNo
* @return void
*/
function pagination(pageCount, pageNo)
{
    var paginationCtrls = "";

    // Only if there is more than 1 page worth of results give the user pagination controls
    if (1 !== pageCount) {
        
        if (1 < pageNo) {
            paginationCtrls += '<button onclick="pagination(' + pageCount + ',' + (pageNo-1) + ')">&lt</button>';
        }

        paginationCtrls += ' &nbsp; &nbsp; <b>Page '+ pageNo +' of '+ pageCount +'</b> &nbsp; &nbsp; ';

        if (pageNo !== pageCount) {
            paginationCtrls += '<button onclick="pagination(' + pageCount + ',' + (pageNo+1) + ')" style="height: 30px;\n\
            width: 30px">&gt</button>';
        }
    }

    $("#paginationControls").html(paginationCtrls);
    
    $.ajax({
        url: 'searchPaginate.php', 
        dataType : 'html',
        type : 'POST',
        data : {
            'pageNo' : pageNo,
            'totalPage' : pageCount,
            'action' : 'pagination',
        },
        success : function(data){
            resultHTML(data);
        }
    });
}

/**
* Function for executing search result
*
* @access public
* @param  object data
* @return void
*/
function resultHTML(data) {
    
    var resultSearch = JSON.parse(data);
    var html = '';
    html += '<table class="table table-responsive" id="display"><thead><tr><th>Serial No.</th>\n\
            <th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Date of Birth</th>\n\
            <th>Office Address</th><th>Residential Address</th>\n\<th>Marital  Status</th>\n\
            <th>Employement Status</th><th>Employer</th><th>Communication</th><th>Image</th>\n\
            <th>Note</th>';
    
    if (1 === editPermission)
    {
        html += '<th>Edit</th>';
    }
    
    if (1 === deletePermission)
    {
        html += '<th>Delete</th>';
    }
   
    html += '</tr></thead><tbody id="employeeListTableBody">';
                
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
            
            
            if('admin' === role && 1 === editPermission)
            {
                html += '<a href="registration.php?edit=' + object['EmpID'] + '&action=edit">\n\
                    <span  class="glyphicon glyphicon-pencil"></span></a>';
            }
            else if ( id == object['EmpID'] && 1 === editPermission)
            { 
                html += '<a href="registration.php"><span  class="glyphicon glyphicon-pencil"></span></a>';
            }
            
            html += '</td>';
            
            // Delete graphic-->
            if (1 === deletePermission)
            {
                html += '<td><a href="list.php?delete=' + object['EmpID'] + '&action=del"><span \n\
                    class="glyphicon glyphicon-remove"></span></a></td>';
            }

            html += '</tr>';
            i++;
        });

        html += '</tbody></table>';
        $("#display").html(html);
    }
    else {
        html = '<h1>Sorry! No result found</h1>';
        $("#display").html(html);
        $("#paginationControls").html('');
    }
}