<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager; // Inject the EntityManagerInterface via constructor

    }
    #[Route('/export/excel', name: 'app_export_excel')]
    public function index(TicketRepository $ticketRepository): Response
    {

        $repository = $this->entityManager->getRepository(Ticket::class); // Replace with your entity class

        $query = $repository->createQueryBuilder('e')
            ->orderBy('e.date', 'ASC') // Replace 'yourField' with the field you want to order by
            ->getQuery();



        $tickets = $query->getResult();




        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();

        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'TICKET'); // Replace 'Your Title Here' with your desired title

        // Merge the cells to create a title cell that spans the columns
        $sheet->mergeCells('A1:N1');

        // Set title cell styling (optional)
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1')->applyFromArray($styleArray);

        // Add headers to the Excel sheet
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Title');
        $sheet->setCellValue('D2', 'Description');
        $sheet->setCellValue('E2', 'Createur');
        $sheet->setCellValue('F2', 'Développeur');
        $sheet->setCellValue('G2', 'Status');
        $sheet->setCellValue('H2', 'Date');
        $sheet->setCellValue('I2', 'DateTaken');
        $sheet->setCellValue('J2', 'DateResolved');
        $sheet->setCellValue('K2', 'Code');
        $sheet->setCellValue('L2', 'Admin');
        $sheet->setCellValue('M2', 'Resolved');
        $sheet->setCellValue('N2', 'Complain');
        $sheet->setCellValue('O2', 'Commentary');

        $sheet->getDefaultColumnDimension()->setWidth(15); // Adjust the width as needed

        // Set the same height for all rows
        $sheet->getDefaultRowDimension()->setRowHeight(20); // Adjust the height as needed
        $row = 3;
        foreach ($tickets as $ticket) {
            $sheet->setCellValue('B' . $row, $ticket->getId());
            $sheet->setCellValue('C' . $row, $ticket->getTitle());
            $sheet->setCellValue('D' . $row, $ticket->getDescription());
            $sheet->setCellValue('E' . $row, $ticket->getCreator()->getLastname());
            $sheet->setCellValue('F' . $row, ""); // Replace 'Developpeur' with the actual property name
            $sheet->setCellValue('G' . $row, $ticket->getStatus()); // Replace 'Status' with the actual property name
            $sheet->setCellValue('H' . $row, $ticket->getDate()); // Replace 'Date' with the actual property name
            $sheet->setCellValue('I' . $row, $ticket->getDateTaken()); // Replace 'DateTaken' with the actual property name
            $sheet->setCellValue('J' . $row, $ticket->getDateResolved()); // Replace 'DateResolved' with the actual property name
            $sheet->setCellValue('K' . $row, $ticket->getCode()); // Replace 'Code' with the actual property name
            $sheet->setCellValue('L' . $row, $ticket->getResolved() ? 'Yes' : 'No'); // Replace 'Resolved' with the actual property name
            $sheet->setCellValue('M' . $row, $ticket->getComplain()); // Replace 'Complain' with the actual property name

            // Add more properties as needed
            $row++;
        }

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'ticket_list.xlsx');
        $writer->save($tempFilePath);

        // Return the Excel file as a response
        return $this->file($tempFilePath, 'ticket_list.xlsx', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
