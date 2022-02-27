<x-layout>
  <section class="movie-wrapper">
    <h1 class="movie-title">{{ $movie['title'] }}</h1>
    <p class="movie-year">Released <span class="bold-paragraph">{{ $movie['released'] }}</span></p>
    <p class="movie-rating">Rating <span class="bold-paragraph">{{ $movie['avg_rating'] }}/10</span> </p>
    <div class="movie-media">
      <img class="movie_poster" src="{{ $movie['urls_images'] }}" alt="movie poster" />
      <iframe class="movie_trailer" src="{{ $movie['url_trailer'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <p class="movie-genre">{{ $movie['genre'] }}</p>
    <div class="movie-cast">
      @foreach ($movie['cast'] as $actor)
        <p>{{ $actor }}</p>
      @endforeach
    </div>
    <p class="movie-abstract">{{ $movie['abstract'] }}</p>
  </section>
  <section class="reviews-section">
    <h2>Reviews</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Rate this movie
</button>
    
@foreach ($reviews as $review)
      <?php $date = date_create($review['created_at']); ?>
      <!-- <div class="review-wrapper"> -->
      <div class="mb-2 shadow-lg rounded-t-8xl rounded-b-5xl overflow-hidden">
      <div class="pt-3 pb-3 md:pb-1 px-4 md:px-16 bg-white bg-opacity-40">
        <div class="flex flex-wrap items-center">
        <h3 class="w-full md:w-auto text-xl font-heading font-medium">{{ $review['user_name'] }}</h3>
        <p class="mb-8 text-sm text-gray-300">{{ date_format($date, 'Y-m-d') }}</p>
        <div class="w-full md:w-px h-2 md:h-8 mx-8 bg-transparent md:bg-gray-200"></div>
          <div class="inline-flex">
              @for ($i = 0; $i < $review['review_rating']; $i++)
            <a class="inline-block mr-1" href="#">
              <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 7.91677H12.4167L10 0.416763L7.58333 7.91677H0L6.18335 12.3168L3.81668 19.5834L10 15.0834L16.1834 19.5834L13.8167 12.3168L20 7.91677Z" fill="#FFCB00"></path>
              </svg>
            </a>
            @endfor
          </div>
        </div>
        <h3 class="w-full md:w-auto text-l font-heading font-medium">{{$review['title']}} </h3>
        <p class="mb-8 max-w-2xl text-darkBlueGray-400 leading-loose">{{ $review['review_content'] }}</p>
      </div>
      <br>
    @endforeach
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">This movie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="{{url('store-review')}}" method="post">
    @csrf 
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                          <div class="rating-css">
                          <div class="star-icon">
                            <input type="radio" value="1" name="movie_rating" checked id="rating1">
                            <label for="rating1" class="fa fa-star"></label>
                            <input type="radio" value="2" name="movie_rating" id="rating2">
                            <label for="rating2" class="fa fa-star"></label>
                            <input type="radio" value="3" name="movie_rating" id="rating3">
                            <label for="rating3" class="fa fa-star"></label>
                            <input type="radio" value="4" name="movie_rating" id="rating4">
                            <label for="rating4" class="fa fa-star"></label>
                            <input type="radio" value="5" name="movie_rating" id="rating5">
                            <label for="rating5" class="fa fa-star"></label>
                            <input type="radio" value="6" name="movie_rating" id="rating6">
                            <label for="rating5" class="fa fa-star"></label>
                            <input type="radio" value="7" name="movie_rating" id="rating7">
                            <label for="rating5" class="fa fa-star"></label>
                            <input type="radio" value="8" name="movie_rating" id="rating8">
                            <label for="rating5" class="fa fa-star"></label>
                            <input type="radio" value="9" name="movie_rating" id="rating9">
                            <label for="rating5" class="fa fa-star"></label>
                            <input type="radio" value="10" name="movie_rating" id="rating10">
                            <label for="rating5" class="fa fa-star"></label>
                        </div>
                    </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="title">Title</label>
                            <input class="appearance-none block w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" id="title" name="title">
                        </div>
                        </div>
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Content</label>
                            <div class="mt-1">
                            <input type="text" id="content"name="content" class="block p-4 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="">
                            <input type="hidden" id="user_id" name="user_id" value="5">
                            <input type="hidden" id="movie_id" name="movie_id" value="5">
                            <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Submit</button>
                            </div>
                            </form>      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
  </section>
</x-layout>