import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
import { User } from '../models/user';
@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService) { }

  getAllUsers()
  {
   return this.http.get<User[]>(this.serviceUrl.host+this.serviceUrl.adminUsers);
  }

  adminDeleteUsers(u_id){
    let adminuser = new FormData();
        adminuser.append("u_id",u_id);
    return this.http.post<any>(this.serviceUrl.host+this.serviceUrl.adminDeleteUsers,adminuser);
  }
}
