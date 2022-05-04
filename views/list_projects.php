<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<?php

$projects = $_SESSION['memsource_api']->getProjectsList();
?>

<h2>Projects List</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Source lang</th>
            <th>Target lang</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    <?php
    foreach ($projects as $project) {
        $targetLangs = '';
        foreach ($project->targetLangs as $lang){ $targetLangs = $targetLangs."".$lang.", "; }
        echo "<tr>
            <td>$project->name</td>
            <td>$project->status</td>
            <td>$project->sourceLang</td>
            <td>$targetLangs</td>
            <td><button onclick='getProjectDetails(\"$project->uid\")'>Show More</button> </td>
        </tr>
        ";
    }
    ?>
    </tbody>
</table>

<div id="details_div">

</div>

</body>

<script>
    function getProjectDetails(projectId){
        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("index.php?action=project_details&projectId="+projectId, requestOptions)
            .then(response => response.json())
            .then(
                result => showDetails(result)

            )
            .catch(
                error => console.log('error', error)
            );
    }

    function showDetails(data){
        let div = document.getElementById('details_div');
        Object.keys(data).forEach(key => {
            var p = document.createElement('p');
            p.innerHTML = "<span>"+key+"</span>: <span>"+data[key]+"<span>";
            div.appendChild(p);
        });

    }
</script>

</html>