<template>
  <div>
    <!-- Trending Movies -->
    <div class="px-4 mb-8">
      <SectionTitle title="Trending Now" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in trendingMovies" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>

    <!-- Top Rated -->
    <div class="px-4 mb-8">
      <SectionTitle title="Top Rated" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in topRatedMovies" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>

    <!-- Upcoming -->
    <div class="px-4 mb-8">
      <SectionTitle title="Coming Soon" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in upcomingMovies" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>

    <!-- Action Movies -->
    <div class="px-4 mb-8">
      <SectionTitle title="Action Movies" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in actionMovies" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>

    <!-- Comedy Movies -->
    <div class="px-4 mb-8">
      <SectionTitle title="Comedy Movies" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in comedyMovies" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import MovieCard from './MovieCard.vue'
import SectionTitle from './SectionTitle.vue'

const router = useRouter()

const trendingMovies = ref([
  {
    id: 101,
    title: 'Oppenheimer',
    year: '2023',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1518929458119-e5bf444c30f4?w=200&h=300&fit=crop'
  },
  {
    id: 102,
    title: 'The Bear',
    year: '2022',
    type: 'series',
    thumbnail: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=200&h=300&fit=crop'
  },
  {
    id: 103,
    title: 'Spider-Man: No Way Home',
    year: '2021',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1534531173927-aeb928d54385?w=200&h=300&fit=crop'
  },
  {
    id: 104,
    title: 'The Last of Us',
    year: '2023',
    type: 'series',
    thumbnail: 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=200&h=300&fit=crop'
  }
])

const topRatedMovies = ref([
  {
    id: 201,
    title: 'The Shawshank Redemption',
    year: '1994',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200&h=300&fit=crop'
  },
  {
    id: 202,
    title: 'The Godfather',
    year: '1972',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?w=200&h=300&fit=crop'
  },
  {
    id: 203,
    title: 'Pulp Fiction',
    year: '1994',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1478720568477-b0a8d129c8d4?w=200&h=300&fit=crop'
  },
  {
    id: 204,
    title: 'Schindler\'s List',
    year: '1993',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=200&h=300&fit=crop'
  }
])

const upcomingMovies = ref([
  {
    id: 301,
    title: 'Deadpool 3',
    year: '2024',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1434394354979-a235cd36269d?w=200&h=300&fit=crop'
  },
  {
    id: 302,
    title: 'Fantastic Four',
    year: '2025',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=200&h=300&fit=crop'
  },
  {
    id: 303,
    title: 'Blade',
    year: '2025',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=200&h=300&fit=crop'
  },
  {
    id: 304,
    title: 'Avatar 3',
    year: '2025',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1518929458119-e5bf444c30f4?w=200&h=300&fit=crop'
  }
])

const actionMovies = ref([
  {
    id: 401,
    title: 'Fast X',
    year: '2023',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1534531173927-aeb928d54385?w=200&h=300&fit=crop'
  },
  {
    id: 402,
    title: 'Extraction 2',
    year: '2023',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=200&h=300&fit=crop'
  },
  {
    id: 403,
    title: 'The Raid',
    year: '2011',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200&h=300&fit=crop'
  },
  {
    id: 404,
    title: 'Nobody',
    year: '2021',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?w=200&h=300&fit=crop'
  }
])

const comedyMovies = ref([
  {
    id: 501,
    title: 'Guardians of the Galaxy Vol. 3',
    year: '2023',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1478720568477-b0a8d129c8d4?w=200&h=300&fit=crop'
  },
  {
    id: 502,
    title: 'The Grand Budapest Hotel',
    year: '2014',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=200&h=300&fit=crop'
  },
  {
    id: 503,
    title: 'Knives Out',
    year: '2019',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1434394354979-a235cd36269d?w=200&h=300&fit=crop'
  },
  {
    id: 504,
    title: 'The Menu',
    year: '2022',
    type: 'movie',
    thumbnail: 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=200&h=300&fit=crop'
  }
])

const goToMovie = (id) => {
  router.push(`/movie/${id}`)
}
</script>