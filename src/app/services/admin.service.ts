import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService) { }

  getAllUsers()
  {
   return  this.http.get(this.serviceUrl.host+this.serviceUrl.adminUsers);
  }
}
