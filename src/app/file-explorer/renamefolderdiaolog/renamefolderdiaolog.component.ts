import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-renamefolderdiaolog',
  templateUrl: './renamefolderdiaolog.component.html',
  styleUrls: ['./renamefolderdiaolog.component.scss']
})
export class RenamefolderdiaologComponent implements OnInit {

  constructor(public dialogRef: MatDialogRef<RenamefolderdiaologComponent>) {}

  folderName: string;

  ngOnInit() {}

}
