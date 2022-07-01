
import type { User } from '../auth/auth-service';
import HttpService, { type ApiResponse, type CommonObjectKeys } from '../http-service';

export interface BookingSearchPayload extends CommonObjectKeys {
  page?: number;
  limit?: number;
  search?: string;
  sort?: string;
}

export interface Room extends CommonObjectKeys {
  created_at: string;
  id: number;
  name: string;
  updated_at: string;
}

export interface Pagination extends CommonObjectKeys {
  count: number;
  currentPage: number;
  perPage: number;
  total: number;
  totalPages: number;
}

export interface Booking extends CommonObjectKeys {
  created_at: string;
  from_date: string;
  id: number;
  room: Room,
  to_date: string;
  updated_at: string;
  user: User
}

export interface BookingTable extends CommonObjectKeys {
  from_date: Date;
  id: number;
  room: string,
  to_date: Date;
  user: string
}

export interface BookingsResponse extends CommonObjectKeys {
  bookings: Array<Booking>,
  pagination: Pagination,
}

export default class BookingService extends HttpService {
  async index(formData?: BookingSearchPayload): Promise<ApiResponse> {
    const response = await this.get('/bookings', formData);

    return response;
  }

  async logout(): Promise<ApiResponse> {
    const response = await this.post('/logout', null, authHeader());

    if(response.success) {
      localStorage.removeItem('token');
    }

    return response;
  }

  async register(formData: RegistrationPayload): Promise<ApiResponse> {
    const response = await this.post('/register', formData);

    if(response.success) {
      const data : Object = response.data;

      const { access_token, expires_at } = data as {
        access_token: string,
        expires_at: number,
      };

      localStorage.setItem('token', JSON.stringify({
        access_token,
        expires_at
      }));
    }

    return response;
  }
}
