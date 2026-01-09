
import { User, Product, ArtisanEvent, Reservation, Review, FAQ, UserRole } from './types';
import { MOCK_USERS, MOCK_PRODUCTS, MOCK_EVENTS, MOCK_FAQS } from './constants';

class DataStore {
  private static instance: DataStore;
  
  private constructor() {
    this.init();
  }

  static getInstance(): DataStore {
    if (!DataStore.instance) {
      DataStore.instance = new DataStore();
    }
    return DataStore.instance;
  }

  private init() {
    if (!localStorage.getItem('users')) localStorage.setItem('users', JSON.stringify(MOCK_USERS));
    if (!localStorage.getItem('products')) localStorage.setItem('products', JSON.stringify(MOCK_PRODUCTS));
    if (!localStorage.getItem('events')) localStorage.setItem('events', JSON.stringify(MOCK_EVENTS));
    if (!localStorage.getItem('faqs')) localStorage.setItem('faqs', JSON.stringify(MOCK_FAQS));
    if (!localStorage.getItem('reservations')) localStorage.setItem('reservations', JSON.stringify([]));
    if (!localStorage.getItem('reviews')) localStorage.setItem('reviews', JSON.stringify([]));
    if (!localStorage.getItem('contacts')) localStorage.setItem('contacts', JSON.stringify([]));
  }

  getUsers(): User[] { return JSON.parse(localStorage.getItem('users') || '[]'); }
  saveUsers(users: User[]) { localStorage.setItem('users', JSON.stringify(users)); }

  getProducts(): Product[] { return JSON.parse(localStorage.getItem('products') || '[]'); }
  saveProducts(products: Product[]) { localStorage.setItem('products', JSON.stringify(products)); }

  getEvents(): ArtisanEvent[] { return JSON.parse(localStorage.getItem('events') || '[]'); }
  saveEvents(events: ArtisanEvent[]) { localStorage.setItem('events', JSON.stringify(events)); }

  getReservations(): Reservation[] { return JSON.parse(localStorage.getItem('reservations') || '[]'); }
  saveReservations(res: Reservation[]) { localStorage.setItem('reservations', JSON.stringify(res)); }

  getReviews(): Review[] { return JSON.parse(localStorage.getItem('reviews') || '[]'); }
  saveReviews(rev: Review[]) { localStorage.setItem('reviews', JSON.stringify(rev)); }

  getFAQs(): FAQ[] { return JSON.parse(localStorage.getItem('faqs') || '[]'); }
}

export const store = DataStore.getInstance();
