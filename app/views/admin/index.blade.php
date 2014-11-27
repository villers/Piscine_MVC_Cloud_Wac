@extends('layouts.default')

@section('content')
    <?php if(isset($uploads)): ?>
        <h2>Liste des fichiers {{ HTML::linkRoute('admin.files', 'Afficher tous') }}</h2>
        <table class="table table-striped table-flip-scroll cf">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>User</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uploads as $upload)
                    <tr>
                        <td>{{ $upload->id }}</td>
                        <td>
                            <a class="fancybox fancybox.iframe" href="{{ URL::to('/uploads/'.md5($upload->user_id).'/'.$upload->nom) }}">
                                {{ e($upload->nom) }}
                            </a>
                        </td>
                        <td>{{ e($upload->type) }}</td>
                        <td>{{ e($upload->user->name) }}</td>
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
    <?php endif; ?>

    <?php if(isset($users)): ?>
        <h2>Liste des utilisateur {{ HTML::linkRoute('admin.users', 'Afficher tous') }}</h2>
        {{ HTML::linkRoute('admin.create_user', 'Créer un utilisateur') }}
        <table class="table table-striped table-flip-scroll cf">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created_at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ e($user->username) }}</td>
                        <td>{{ e($user->email) }}</td>
                        <td>{{ e($user->created_at) }}</td>
                        <td>
                            {{ HTML::linkRoute('admin.user_name', 'Afficher les fichiers', [$user->username], ['class' => 'btn btn-info']) }}
                            {{ HTML::linkRoute('admin.edit_user', 'Editer', [$user->id], ['class' => 'btn btn-primary']) }}
                            {{ HTML::linkRoute('admin.destroy_user', 'Supprimer', [$user->id], ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Êtes vous sur ?\')']) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <ul class="pagination">
            {{ $users->links() }}
        </ul>
    <?php endif; ?>
@stop