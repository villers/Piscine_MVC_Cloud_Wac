@extends('layouts.default')

@section('content')

	<h2>Vous avez utilisé <span id="totalSize">{{ $size }}</span>/50 Mio</h2>
	<a href="#" id="createDir" class="btn btn-info pull-right" data-toggle="modal" data-target="#createfolder"><span class="glyphicon glyphicon-upload"></span> Créer un nouveau dossier</a>

	{{ Form::open(['route' => ['upload.post'], 'method' => 'POST', 'class' => 'dropzone', 'id'=>'my-dropzone'])}}
	{{ Form::close()}}

	<table class="table table-striped" id="upload">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Type</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($uploads as $upload)
				<tr>
					<td>{{ $upload->id }}</td>
					<td>
                        <a class="fancybox fancybox.{{ explode('/', $upload->type)[0]=='image'? 'image':'iframe' }}" href="{{ URL::to('/uploads/'.md5($upload->user_id).'/'.$upload->nom) }}">
                            {{ e($upload->nom) }}
                        </a>
                    </td>
					<td>{{ e($upload->type) }}</td>
					<td>
						{{ HTML::linkRoute('upload.download', 'Télécharger', [$upload->id], ['class' => 'btn btn-success']) }}
						{{ HTML::linkRoute('upload.share', 'Partager', [$upload->id], ['class' => 'btn btn-info']) }}
						{{ HTML::linkRoute('upload.rename', 'Renomer', [$upload->id], ['class' => 'btn btn-primary']) }}
						{{ HTML::linkRoute('upload.delete', 'Supprimer', [$upload->id], ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Êtes vous sur ?\')']) }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<ul class="pagination">
		{{ $uploads->links() }}
	</ul>

	<div class="modal fade" id="createfolder" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Créer un nouveau dossier</h4>
				</div>
				<div class="modal-body">
					<form method="POST" role="form">
						<div class="form-group">
							<label for="foldername">Nom du dossier</label>
							<input type="text" class="form-control" id="foldername" name="nom" placeholder="Nom du dossier">
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
							<button type="submit" class="btn btn-primary">Créer le Dossier</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="preview">
		<div class="previewContent"></div>
	</div>
@stop