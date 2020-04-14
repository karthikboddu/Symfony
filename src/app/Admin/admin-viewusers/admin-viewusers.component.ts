import { Component, OnInit, ViewChild } from '@angular/core';
import { AdminService } from 'src/app/services/admin.service';
import { MatTableDataSource, MatPaginator, MatSort } from '@angular/material';
import { User } from 'src/app/models/user';
import { DataSource } from '@angular/cdk/collections';
import { Observable } from 'rxjs';
import { BlockScrollStrategy } from '@angular/cdk/overlay';

@Component({
  selector: 'app-admin-viewusers',
  templateUrl: './admin-viewusers.component.html',
  styleUrls: ['./admin-viewusers.component.scss']
})
export class AdminViewusersComponent implements OnInit {

  allUsers: any;
  selected:any;
  role_selected:any;
  allUsersData: User[];
  userSelected: User[];
  displayedColumns = ['id', 'name', 'surname', 'username', 'email', 'roles', 'created_at', 'password', 'phonenumber', 'active', 'details', 'update', 'delete'];
  dataSource: MatTableDataSource<User>;
  //datasource = new UserDataSource(this.admin);
  roles = ['Role Admin','Role User'];

  @ViewChild(MatPaginator, { static: false }) paginator: MatPaginator;
  @ViewChild(MatSort, { static: false }) sort: MatSort;
  constructor(private admin: AdminService) {

    //  for (let i = 1; i <= 100; i++) { users.push(createNewUser(i)); }

  }

  ngOnInit() {

    const users: User[] = [];
    this.allUsers = this.admin.getAllUsers().subscribe(
      data => {
        this.allUsersData = data;
        this.dataSource.data = data as User[];
        console.log(this.allUsersData,"adminusers");
      },
      error => {
        console.log(error);
      });

    // Assign the data to the data source for the table to render
    this.dataSource = new MatTableDataSource(users);
    // console.log("datasource", this.dataSource);


  }
  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
    this.dataSource.sort = this.sort;
  }

  applyFilter(filterValue: string) {
    filterValue = filterValue.trim(); // Remove whitespace
    filterValue = filterValue.toLowerCase(); // Datasource defaults to lowercase matches
    this.dataSource.filter = filterValue;
    console.log("datasss", this.dataSource);
  }
  public redirectToDetails = (id: string) => {

  }

  public redirectToUpdate = (id: string) => {

  }

  public redirectToDelete = (id: number,active:boolean) => {
    if (id) {
      debugger
      this.allUsersData.forEach(element => {
        if (element.id == id) {
          this.admin.adminDeleteUsers(id).subscribe(res => {
            console.log("deleteuser", res);
            if (res.code == '200') {
              element.active = false;
            } else {

            }
          }, error => {
            console.log(error);
          });

        }
      });
    }


  }


  filterChanged(event){
  debugger
  }
}

/** Builds and returns a new User. */
function createNewUser(ele: User): User {
  const name =
    NAMES[Math.round(Math.random() * (NAMES.length - 1))] + ' ' +
    NAMES[Math.round(Math.random() * (NAMES.length - 1))].charAt(0) + '.';

  return {
    id: ele.id,
    name: ele.name,
    surname: ele.surname,
    username: ele.username,
    email: ele.email,
    roles: ele.roles,
    created_at: ele.created_at,
    password: ele.password,
    phonenumber: ele.phonenumber,
    active: ele.active,

  };
}
export class UserDataSource extends DataSource<User> {
  constructor(private admind: AdminService) {
    super();
  }
  connect(): Observable<User[]> {
    return this.admind.getAllUsers();
  }
  disconnect() { }
}
/** Constants used to fill up our data base. */
const COLORS = ['maroon', 'red', 'orange', 'yellow', 'olive', 'green', 'purple',
  'fuchsia', 'lime', 'teal', 'aqua', 'blue', 'navy', 'black', 'gray'];
const NAMES = ['Maia', 'Asher', 'Olivia', 'Atticus', 'Amelia', 'Jack',
  'Charlotte', 'Theodore', 'Isla', 'Oliver', 'Isabella', 'Jasper',
  'Cora', 'Levi', 'Violet', 'Arthur', 'Mia', 'Thomas', 'Elizabeth'];


export interface UserData {
  id: string;
  name: string;
  progress: string;
  color: string;
}