<html>
	<head>
		
<link rel="stylesheet" href="Content/bootstrap.css"/> 
<link rel="stylesheet" href="Content/bootstrap-responsive.css"/> 
<link rel="stylesheet" href="Content/style.css" />
<script type="text/javascript" src="Content/jquery.js"></script>
<script type="text/javascript" src="Content/bootstrap.js"></script>
<script>
    $(document).ready(function(){
        $("td").click(function(){
            $(this).addClass("success");
        });
    });
</script>
<style>
    .table tbody td.success {
        background-color: #dff0d8;
    }
</style>
	</head>
<body>

<table class="table table-bordered">
    <thead>
        <tr class="success">
            <td></td>
            <th scope="col">Monday</th>
            <th scope="col">Tuesday</th>
            <th scope="col">Wednesday</th>
            <th scope="col">Thursday</th>
            <th scope="col">Friday</th>
            <th scope="col">Saturday</th>
        </tr>
    </thead>
    <tbody>
        <tr class="success">
            <td class="user">Sam</td>
            <td class="success"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="user">Mallory</td>
            <td class="success"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="user">Ethan</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="user">Kate</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="user">Carl</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>





</body>
</html>