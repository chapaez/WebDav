<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin panel</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
	<script src="main.js"></script>
	<style>
		body{
			padding-top: 50px;
		}
		.scroll-content{
			max-height: 600px;
		}
		.form-inline .form-control{
			width: calc(100% - 80px);
		}
		.table-url td {
			animation: flash .5s ease;
		}
		@keyframes flash{
			0% {
				color: red;
			}
			50%{
				color: #000;
			},
			100%{
				color: red;
			}
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="text-lg-center">Admin Panel</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<h2 class="text-lg-center">Form</h2>
				<div class="form">
					<div class="form-group">
						<label for="url-input">Paste URL for cache clear</label>
						<div class="form-inline">
								<input class="form-control js-input-clear" type="url" name="input-url" placeholder="write url here...">
								<button type="submit" class="btn btn-primary js-btn-clear">Clear</button>
						</div>
						<div class="form-check">
							<label class="form-check-label" for="checkbox-section">
								<input class="form-check-input js-checkbox-clear" type="checkbox" name="checkbox-section">
								Clear Section
							</label>
						</div>
						<small class="form-text text-muted">Set checkbox if you want clear all section</small>
						<div class="alert-wrap m-t-1">
							<div class="alert alert-warning" hidden>
								<strong>Warning!</strong> The url input must be requred!
							</div>
							<div class="alert alert-success" hidden>
								<strong>Success!</strong> You query executed!
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="url-input">Paste URL for add to cache</label>
						<div class="form-inline">
								<input class="form-control js-input-add" type="url" name="input-url" placeholder="write url here...">
								<button type="submit" class="btn btn-primary js-btn-add">Add</button>
						</div>
						<div class="alert-wrap m-t-1">
							<div class="alert alert-warning" hidden>
								<strong>Warning!</strong> The url input must be requred!
							</div>
							<div class="alert alert-success" hidden>
								<strong>Success!</strong> You query executed!
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<h2 class="text-lg-center">URL list
					<button type="submit" class="btn btn-primary pull-right js-btn-reset">Reset</button>
				</h2>
				<div class="pre-scrollable scroll-content">
					<table class="table  table-striped table-hover">
						<thead class="thead-inverse">
							<tr>
								<th>#</th>
								<th>Command</th>
								<th>Time</th>
								<th>URL</th>
							</tr>
						</thead>
						<tbody id="table-url">
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</body>
</html>