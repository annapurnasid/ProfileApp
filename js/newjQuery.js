
$( document ).ready(function(){
    $('#searchButton').on('click', function() {
        var name = $('#nameSearch').val();
        var email = $('#emailSearch').val();

        $.ajax({
            url: 'ajaxSample.php', 
            dataType : 'html',
            type : 'POST',
            data : {
                'name' : name,
                'search' : true
            },
            success : function(data){
                var resultSearch = JSON.parse(data);
                var html = '';
                html += '<table class="table table-responsive" id="display"><thead><tr><th>Serial No.</th><th>Name</th><th>Email</th>\n\
                <th>Phone</th><th>Gender</th><th>Date of Birth</th><th>Office Address</th><th>Residential Address</th>\n\<th>Marital  Status</th>\n\
                <th>Employement Status</th><th>Employer</th><th>Communication</th><th>Image</th><th>Note</th><th>Edit</th><th>Delete</th></tr>\n\
                </thead><tbody id="employeeListTableBody">'
                
                
                
                if(0 !== resultSearch.length) {
                    var i = 1;
                    resultSearch.forEach(function(object){
                        console.log(object);
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

                            console.log(object[key]);
                            html += '</td>';
                        }
                        html += '<td>';
                        if ( id == object['EmpID'])
                        { 
                            html += '<a href="registration.php"><span  class="glyphicon glyphicon-pencil"></span></a>';
                        }
                        html += '</td>';

                        // Delete graphic-->
                        html += '<td><a href="list.php?delete=' + object['EmpID'] + '"><span  class="glyphicon glyphicon-remove"></span></a></td>';


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
        });
    });
});