import { Component, OnInit , Input, Output, EventEmitter, ViewChild} from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { UploadService } from './upload.service';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';
import { FileElement } from '../../models/file-explorer';
import { FileService } from '../../services/file.service';
import { first } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Response, fileUpload } from '../../models/post';
import {FileResponse} from '../../models/file-explorer';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import {SelectionModel} from '@angular/cdk/collections';
import { PostService } from 'src/app/services/post.service';

@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})

export class UploadComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService,public fileService:FileService,public postService:PostService) { }

  currentRoot: FileElement;
  userfiledata : any;
  fe :FileElement[];
  public fileElements: Observable<FileElement[]>;
  fileReponse : FileResponse;

  allUsers: any;
  selected:any;
  role_selected:any;
  allUsersData: any;
  userSelected: any;
  //displayedColumns = ['id', 'name', 'surname', 'username', 'email', 'roles', 'created_at', 'password', 'phonenumber', 'active', 'details', 'update', 'delete'];
  //dataSource: MatTableDataSource<any>;

  //@ViewChild(MatPaginator) paginator: MatPaginator;
  //@ViewChild(MatSort) sort: MatSort;
  uploadData : fileUpload[];
  displayedColumns: string[] = ['position', 'name', 'weight', 'symbol','delete'];
  dataSource: MatTableDataSource<fileUpload>;
  selection = new SelectionModel<fileUpload>(true, []);

  @ViewChild(MatSort, {static: true}) sort: MatSort;
  @ViewChild(MatPaginator, {static: true}) paginator: MatPaginator;
 
  ngOnInit() {
    // this.dataSource.paginator = this.paginator;
    // this.dataSource.sort = this.sort;

    this.loadUploadedData('uploaded');
      //dataSource = new MatTableDataSource<fileUpload>(this.uploadData);
      
  }
  ngAfterViewInit() {
    this.dataSource = new MatTableDataSource(this.uploadData);
    console.log(this.dataSource);
    this.dataSource.paginator = this.paginator;
    this.dataSource.sort = this.sort;
  }
  
  // async ngOnDestroy() {
  //   if (this.userfiledata) {
  //       this.userfiledata.unsubscribe();
  //   }

    
  // }

  loadUploadedData(type){
    debugger
    this.uploadService.getMediaUploadData(type)
    .pipe(first())
    .subscribe(data=>{
        
        this.uploadData = data;
        this.dataSource.data = this.uploadData;
        console.log("mediadata",this.uploadData);
      },
      error =>{
        console.log("errors", error);
      }); 
  }

  redirectToDelete(id){
debugger
    this.postService.postByUploadId(id)
    .pipe(first())
    .subscribe(data=>{
        
 console.log(data);
      },
      error =>{
        console.log("errors", error);
      }); 

  }
  newfileElement: FileElement;
  fileUploadId ;
  addFiles(folder) {
    debugger
    if(this.fileService.getFileEle()){
      this.currentRoot = this.fileService.getFileEle();
    }
   
   for (let i = 0; i < folder.name.length; i++) {
     console.log(folder.name[i].name,"fname");
    this.newfileElement = this.fileService.add({ isfolder: false, name: folder.name[i].name, parent: this.currentRoot ? this.currentRoot.fid : 'root' ,id:''});
  }
   this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'false',this.currentRoot ? this.currentRoot.fid : 'root')
   .pipe(first())
   .subscribe(data=>{
       console.log("addData",data);

     },
     error =>{
       console.log("errors", error);
     });


    this.updateFileElementQuery();
 }


 updateFileElementQuery() {
   debugger
  this.fileElements = this.fileService.queryInFolder(this.currentRoot ? this.currentRoot.fid : 'root');
  console.log(this.fileElements,"Sdsd");
}


 /** Whether the number of selected elements matches the total number of rows. */
 isAllSelected() {
  const numSelected = this.selection.selected.length;
  const numRows = this.dataSource.data.length;
  return numSelected === numRows;
}

/** Selects all rows if they are not all selected; otherwise clear selection. */
masterToggle() {
  console.log(this.selection);
  this.isAllSelected() ?
      this.selection.clear() :
      this.dataSource.data.forEach(row => this.selection.select(row));
}

/** The label for the checkbox on the passed row */
checkboxLabel(row?: fileUpload): string {
  if (!row) {
    return `${this.isAllSelected() ? 'select' : 'deselect'} all`;
  }
  return `${this.selection.isSelected(row) ? 'deselect' : 'select'} row ${row.fut_id + 1}`;
}







}

export interface PeriodicElement {
  name: string;
  position: number;
  weight: number;
  symbol: string;
}

const ELEMENT_DATA: PeriodicElement[] = [
  {position: 1, name: 'Hydrogen', weight: 1.0079, symbol: 'H'},
  {position: 2, name: 'Helium', weight: 4.0026, symbol: 'He'},
  {position: 3, name: 'Lithium', weight: 6.941, symbol: 'Li'},
  {position: 4, name: 'Beryllium', weight: 9.0122, symbol: 'Be'},
  {position: 5, name: 'Boron', weight: 10.811, symbol: 'B'},
  {position: 6, name: 'Carbon', weight: 12.0107, symbol: 'C'},
  {position: 7, name: 'Nitrogen', weight: 14.0067, symbol: 'N'},
  {position: 8, name: 'Oxygen', weight: 15.9994, symbol: 'O'},
  {position: 9, name: 'Fluorine', weight: 18.9984, symbol: 'F'},
  {position: 10, name: 'Neon', weight: 20.1797, symbol: 'Ne'},
  {position: 11, name: 'Sodium', weight: 22.9897, symbol: 'Na'},
  {position: 12, name: 'Magnesium', weight: 24.305, symbol: 'Mg'},
  {position: 13, name: 'Aluminum', weight: 26.9815, symbol: 'Al'},
  {position: 14, name: 'Silicon', weight: 28.0855, symbol: 'Si'},
  {position: 15, name: 'Phosphorus', weight: 30.9738, symbol: 'P'},
  {position: 16, name: 'Sulfur', weight: 32.065, symbol: 'S'},
  {position: 17, name: 'Chlorine', weight: 35.453, symbol: 'Cl'},
  {position: 18, name: 'Argon', weight: 39.948, symbol: 'Ar'},
  {position: 19, name: 'Potassium', weight: 39.0983, symbol: 'K'},
  {position: 20, name: 'Calcium', weight: 40.078, symbol: 'Ca'},
];
