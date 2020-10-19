import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocentesMeetingProcessComponent } from './docentes-meeting-process.component';

describe('DocentesMeetingProcessComponent', () => {
  let component: DocentesMeetingProcessComponent;
  let fixture: ComponentFixture<DocentesMeetingProcessComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocentesMeetingProcessComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocentesMeetingProcessComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
