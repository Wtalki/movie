# StreamFlix - Movie Streaming Mobile App

A sleek, modern movie streaming mobile app UI built with Vue.js 3 and Tailwind CSS. This app features a dark theme with neon highlights and provides an immersive mobile-first experience for browsing and watching movies and TV shows.

## ✨ Features

### 🏠 Home Screen
- Personalized greeting with user name
- Large featured movie banner with gradient overlay
- **Continue Watching** section with progress indicators
- **What's New** and **Some Thrills** horizontal scrolling sections
- Movie cards with hover effects and smooth transitions

### 🔍 Search & Category Screen
- Responsive search bar with icon
- Filter chips (Featured, Drama, Sci-Fi, Thriller, etc.)
- **Trending** section with numeric ranking badges (#1, #2, #3)
- **For You** and **Exploring the Space** content sections
- Pill-style filter design with active states

### 🎬 Movie Detail Screen
- Edge-to-edge movie poster with gradient overlay
- Movie metadata (year, rating, HD/CC tags)
- Genre tags with pill design
- Prominent yellow Play button
- Detailed synopsis section
- Tabbed interface for:
  - **Episodes** with season dropdown
  - **Trailers & Extras**
  - **Subtitles** with language selection

### 🎨 Design System
- **Dark Theme**: Primary background `#0e0e0e`
- **Neon Accents**: Yellow highlights `#facc15`
- **Smooth Transitions**: Hover effects and tab switching
- **Mobile-First**: Optimized for mobile devices
- **Rounded Design**: Cards and buttons with `rounded-xl`
- **Shadow Effects**: Subtle `shadow-lg` for depth

## 🛠️ Tech Stack

- **Vue.js 3** with Composition API (`<script setup>`)
- **Vue Router 4** for navigation
- **Tailwind CSS 3** for styling
- **HeroIcons** for iconography
- **Vite** for build tooling

## 🚀 Quick Start

### Prerequisites
- Node.js 16+ 
- npm or yarn

### Installation

1. **Install dependencies:**
   \`\`\`bash
   npm install
   \`\`\`

2. **Start development server:**
   \`\`\`bash
   npm run dev
   \`\`\`

3. **Open your browser:**
   Navigate to `http://localhost:3000`

### Build for Production

\`\`\`bash
npm run build
\`\`\`

## 📱 Screen Navigation

- **Home** (`/`) - Main dashboard with featured content
- **Search** (`/search`) - Browse and filter movies
- **Movie Detail** (`/movie/:id`) - Detailed movie information

## 🎯 Key Components

### Navigation Bar
- Fixed bottom navigation with 4 sections
- Active state highlighting with neon color
- Icons: Home, Search, Favorites, Profile

### Movie Card
- Responsive thumbnail display
- Play button overlay for "Continue Watching"
- Progress bar for partially watched content
- Hover effects with scale transformation

### Section Title
- Consistent heading component
- Optional "See All" link
- Used across all content sections

## 🎨 Custom Tailwind Configuration

```javascript
// Custom colors and utilities
colors: {
  dark: '#0e0e0e',
  'dark-card': '#1a1a1a', 
  'dark-lighter': '#2a2a2a',
  neon: '#facc15'
}
```

## 📦 Project Structure

```
src/
├── components/          # Reusable Vue components
│   ├── MovieCard.vue   # Movie thumbnail component
│   ├── NavigationBar.vue # Bottom navigation
│   └── SectionTitle.vue # Section headers
├── screens/            # Main application screens
│   ├── HomeScreen.vue  # Home dashboard
│   ├── SearchScreen.vue # Search & categories
│   └── MovieDetailScreen.vue # Movie details
├── main.js            # App entry point
├── App.vue            # Root component
└── style.css          # Global styles
```

## 🎪 Demo Content

The app includes sample movie data with:
- Popular movies and TV shows
- Realistic thumbnails via Unsplash
- Progress tracking for "Continue Watching"
- Multiple seasons and episodes
- Trending rankings and ratings

## 🔮 Future Enhancements

- User authentication and profiles
- Real movie API integration
- Video playback functionality  
- Offline viewing capabilities
- Push notifications for new content
- Social features and sharing

## 📄 License

This project is open source and available under the [MIT License](LICENSE).