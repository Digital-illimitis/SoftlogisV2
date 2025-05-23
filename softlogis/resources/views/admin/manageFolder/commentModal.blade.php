<div class="modal fade" id="commentModal{{ $item->uuid }}" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-uppercase">
                <h6>Commentaire</h3>
            </div>
            @php
                $comments = \App\Models\Comment::where('foreignUuid', $item->uuid)->get();
            @endphp
            <div class="modal-body">
                <div class="chat-content-leftside">
                   @forelse ($comments as $comment)
                        <div class="d-flex mb-3">
                            <img src="{{ asset('avatars/'.$comment->user->avatar)}}" width="25" height="25" class="rounded-circle" alt="" />
                            <div class="flex-grow-1 ms-2">
                                <p class="mb-0 chat-time">
                                    <span>{{ $comment->user->name .' '. $comment->user->name }}</span>, 
                                    <muted>{{ $comment->created_at->diffForHumans() ?? '--'}}</muted>
                                </p>
                                <p class="chat-left-msg">{{ $comment->content ?? '--'}}</p>
                            </div>
                        </div>
                   @empty
                       
                   @endforelse
                    
                    <form action="{{ route('admin.comment.store')}}" method="post" class="submitForm">
                        @csrf
                        <input type="hidden" name="foreignUuid" value="{{ $item->uuid }}">
                        <textarea class="mt-4 form-control" name="content" id="" cols="30" rows="3" placeholder="Saisir commentaire">

                        </textarea>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Commenter</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        
    </div>
</div>