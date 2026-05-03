export interface ApiSuccessResponse<T> {
  success: true;
  status: number;
  message: string;
  data: T;
}

export interface ApiErrorResponse {
  success: false;
  status: number;
  message: string;
  errors: string[];
}
