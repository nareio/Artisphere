
import { UserRole, Product, ArtisanEvent, User, FAQ } from './types';

export const COLORS = {
  primary: '#bfa58a',
  secondary: '#3e2723',
  background: '#f5f1ed',
  card: '#d8ccc0',
  accent: '#795548'
};

export const MOCK_USERS: User[] = [
  {
    id: '1',
    username: 'jmorel',
    email: 'julien.morel@bois.fr',
    role: UserRole.ARTISAN,
    firstName: 'Julien',
    lastName: 'Morel',
    city: 'Nantes',
    specialty: 'Ebéniste Créateur',
    description: 'Passionné par le bois depuis 20 ans.',
    avatar: 'https://picsum.photos/seed/artisan1/200/200'
  },
  {
    id: '2',
    username: 'aduarte',
    email: 'amelie@duarte.fr',
    role: UserRole.ARTISAN,
    firstName: 'Amélie',
    lastName: 'Duarte',
    city: 'Lyon',
    specialty: 'Créatrice de Bijoux',
    description: 'Bijoux faits main en argent et pierres naturelles.',
    avatar: 'https://picsum.photos/seed/artisan2/200/200'
  },
  {
    id: 'admin_user',
    username: 'admin',
    email: 'admin@artisphere.fr',
    role: UserRole.ADMIN,
    firstName: 'System',
    lastName: 'Admin'
  }
];

export const MOCK_PRODUCTS: Product[] = [
  {
    id: 'p1',
    artisanId: '1',
    artisanName: 'Julien Morel',
    name: 'Tabouret en Chêne',
    price: 120,
    category: 'Ameublement',
    description: 'Tabouret sculpté à la main en chêne massif.',
    image: 'https://picsum.photos/seed/tabouret/400/300',
    quantity: 5
  },
  {
    id: 'p2',
    artisanId: '2',
    artisanName: 'Amélie Duarte',
    name: 'Collier Emeraude',
    price: 85,
    category: 'Bijoux',
    description: 'Collier élégant avec pierre naturelle.',
    image: 'https://picsum.photos/seed/collier/400/300',
    quantity: 2
  }
];

export const MOCK_EVENTS: ArtisanEvent[] = [
  {
    id: 'e1',
    artisanId: '1',
    artisanName: 'Julien Morel',
    title: 'Initiation au travail du bois',
    type: 'Atelier',
    description: 'Apprenez les bases de l\'ébénisterie.',
    date: '2025-11-09',
    location: 'Atelier Bois & Matière, Nantes',
    price: 45,
    capacity: 8,
    image: 'https://picsum.photos/seed/event1/400/300'
  }
];

export const MOCK_FAQS: FAQ[] = [
  {
    id: 'f1',
    question: 'Comment se faire rembourser ?',
    answer: 'Les remboursements sont gérés directement avec l\'artisan. Si un litige persiste, contactez-nous.'
  },
  {
    id: 'f2',
    question: 'Comment contacter un créateur ?',
    answer: 'Vous pouvez trouver les informations de contact sur la page de profil de l\'artisan.'
  },
  {
    id: 'f3',
    question: 'J\'ai oublié mon mot de passe, que faire ?',
    answer: 'Utilisez le lien "Mot de passe oublié" sur la page de connexion.'
  }
];
