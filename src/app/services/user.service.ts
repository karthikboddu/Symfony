import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {ServiceUrlService} from '../serviceUrl/service-url.service';
import { User } from '../models/user';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient,private serviceUrl:ServiceUrlService) { }

    getAll() {
        return this.http.get<User[]>(`/users`);
    }

    getById(id: number) {
        return this.http.get(`/users/` + id);
    }

    register(user: User) {
        debugger
        let registeruser = new FormData();
        registeruser.append("name",user.firstName);
        registeruser.append("surname",user.lastName);
        registeruser.append("username",user.username);
        registeruser.append("email",user.email);
        registeruser.append("passowrd",user.password);
        registeruser.append('phonenumber',user.phonenumber);
        return this.http.post(this.serviceUrl.host+this.serviceUrl.register, registeruser);
    }

    update(user: User) {
        return this.http.put(`/users/` + user.id, user);
    }

    delete(id: number) {
        return this.http.delete(`/users/` + id);
    }
}

