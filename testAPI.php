<html>
    <head>
        <title>
            Test
        </title>
    </head>
    <body>
        <script>
            // const filter = {
            //     "narasumber": ["Yulia Oeniyati"],
            //     "event": ["Gosabda"],
            //     "size": 10,
            //     "API": "filter"
            // };
            const filter = {
                "query": "natal",
                "size": 20,
                "API": "search"
            };
            // const filter = {
            //     "narasumber": ["Yulia Oeniyati"],
            //     "event": ["GoSABDA"],
            //     "size": 20,
            //     "API": "searchFilter",
            //     "query": "GoSabda!"
            // };
            const filterJson = JSON.stringify(filter);
            fetch('http://localhost/UI/sabdaPustaka/filterAPI.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: filterJson,
            })
            .then(response => response.json())
            .then(data => {
                // Process the response data
                console.log(data.result.data_result);
                console.log(data.result.unique_narasumber);
                console.log(data.result.unique_tanggal);
                console.log(data.result.unique_event);
            })
            .catch(error => {
                // Handle any errors
                console.error(error);
        });
        </script>
    </body>
</html>