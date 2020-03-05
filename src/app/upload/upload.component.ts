import { Component, OnInit , Input, Output, EventEmitter} from '@angular/core';
import { MatDialog } from '@angular/material';
import { UploadService } from '../services/upload.service';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';
import { FileElement } from '../models/file-explorer';
import { FileService } from '../services/file.service';
import { first } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { Response } from '../models/post';
import {FileResponse} from '../models/file-explorer';
@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService,public fileService:FileService) { }

  currentRoot: FileElement;
  userfiledata : any;
  fe :FileElement[];
  public fileElements: Observable<FileElement[]>;
  fileReponse : FileResponse;
  ngOnInit() {
   
  }

  // async ngOnDestroy() {
  //   if (this.userfiledata) {
  //       this.userfiledata.unsubscribe();
  //   }

    
  // }
  newfileElement: FileElement;
  fileUploadId ;
  addFiles(folder: { name: string }) {
    debugger
   console.log("hhSD",folder.name);
   this.currentRoot = this.fileService.getFileEle();
   console.log(this.currentRoot,"feee");
   this.fileUploadId = this.uploadService.getUserFileUploadId();
   console.log(this.fileUploadId,"file111111111");
   console.log(this.fileUploadId,"file222222222");
   console.log(this.fileUploadId,"fileuploadId");
   this.newfileElement = this.fileService.add({ isfolder: false, name: folder.name, parent: this.currentRoot ? this.currentRoot.fid : 'root' ,id:''});
   this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'false',this.currentRoot ? this.currentRoot.fid : 'root',this.fileUploadId)
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

}
