<!DOCTYPE html>

<html>
	<head>
		<title>%title% - adminpanel</title>
		<meta charset='UTF-8' />
		%head_files%
	</head>
	<body>
		%nav%
	  <div class="container-fluid">
	    <div class="row">
				%menu%
		    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
		      <div class="d-flexd justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		      	<div>%content%
		      		<br>
						</div>
		      </div>
		    </main>
	    </div>
    </div>
		<div dd="wrapper">
			<div class="middle">
				<div class="footer">
					%footer%
				</div>
			</div>
		</div>
    <script>
      feather.replace()
    </script>
	</body>
</html>
