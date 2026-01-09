
export enum UserRole {
  VISITOR = 'visitor',
  CLIENT = 'client',
  ARTISAN = 'artisan',
  ADMIN = 'admin'
}

export interface User {
  id: string;
  username: string;
  email: string;
  role: UserRole;
  avatar?: string;
  firstName?: string;
  lastName?: string;
  city?: string;
  specialty?: string;
  description?: string;
  address?: string;
}

export interface Product {
  id: string;
  artisanId: string;
  artisanName: string;
  name: string;
  price: number;
  category: string;
  description: string;
  image: string;
  materials?: string;
  quantity: number;
}

export interface ArtisanEvent {
  id: string;
  artisanId: string;
  artisanName: string;
  title: string;
  type: 'Atelier' | 'Exposition' | 'Salon';
  description: string;
  date: string;
  location: string;
  price: number;
  capacity: number;
  image: string;
}

export interface Review {
  id: string;
  itemId: string; // Product or Event ID
  userId: string;
  userName: string;
  rating: number;
  comment: string;
  date: string;
}

export interface Reservation {
  id: string;
  userId: string;
  itemId: string;
  itemType: 'product' | 'event';
  itemName: string;
  status: 'pending' | 'completed' | 'cancelled';
  date: string;
}

export interface FAQ {
  id: string;
  question: string;
  answer: string;
}
