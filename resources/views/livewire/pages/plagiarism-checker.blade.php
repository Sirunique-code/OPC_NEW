<div>
    <form wire:submit.prevent="checkPlagiarism">
        <div class="form-group">
            <label for="text">Enter Text to Check</label>
            <textarea wire:model.defer="text" class="form-control" rows="6" placeholder="Paste your content here..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Check Plagiarism</button>
    </form>

    @if ($results)
        <hr>
        <h4>Plagiarism Results:</h4>
        @foreach ($results as $result)
            <div class="card my-2">
                <div class="card-body">
                    <strong>Phrase:</strong> "{{ $result['phrase'] }}"
                    @if (!empty($result['matches']))
                        <ul class="mt-2">
                            @foreach ($result['matches'] as $link)
                                <li><a href="{{ $link }}" target="_blank">{{ $link }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-success mt-2">No matches found online.</p>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
