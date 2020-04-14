import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RenamefolderdiaologComponent } from './renamefolderdiaolog.component';

describe('RenamefolderdiaologComponent', () => {
  let component: RenamefolderdiaologComponent;
  let fixture: ComponentFixture<RenamefolderdiaologComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RenamefolderdiaologComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RenamefolderdiaologComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
