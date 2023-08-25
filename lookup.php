<?php
require_once('tcpdf/tcpdf.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استلام البيانات المرسلة من النموذج
    $id = $_POST['id'];

    // التحقق من صحة البيانات
    if (!empty($id)) {
        // قم بتحديد معلومات اتصال قاعدة البيانات هنا
        $servername = "localhost";
        $username = "id21164872_irash";
        $password = "ilovesos5Q@";
        $dbname = "id21164872_educationalservices";

        // إنشاء اتصال بقاعدة البيانات
        $conn = new mysqli($servername, $username, $password, $dbname);

        // التحقق من نجاح الاتصال
        if ($conn->connect_error) {
            die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
        }
//        $fontname = TCPDF_FONTS::addTTFfont('HS Almaha.ttf', 'TrueTypeUnicode', '', 96);
        // استعلام للتحقق من وجود البيانات في قاعدة البيانات
        $sql = "SELECT * FROM emp_oman WHERE id = '$id'";
        $result = $conn->query($sql);
	// Create a new TCPDF object
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetCreator('Alrasheed Altayeb');
	$pdf->SetAuthor('Alrasheed Altayeb');
	$pdf->SetTitle('إستلام عمل');
	
//	$pdf->SetFont($fontname,'',16);
	// Set font


	// Add form fields
	$pdf->AddPage();
    $pdf->SetFont('aealarabiya', '', 10);
	    $pdf->SetXY(20, 20);
		$pdf->Cell(170, 10, 'سلطنة عمان', 0, 0, 'R');
		$pdf->SetXY(20, 25);
		$pdf->Cell(170, 10, 'وزارة التربية والتعليم', 0, 0, 'R');
		$pdf->SetXY(20, 30);
		$pdf->Cell(170, 10, 'المديرية العامة للتربية والتعليم بمحافظة مسقط', 0, 0, 'R');
		$pdf->SetXY(20, 35);
		$pdf->Cell(170, 10, 'دائرة الشؤون الإدارية', 0, 0, 'R');
		$pdf->SetXY(20, 40);
		$pdf->Cell(170, 10, 'قسم التعيينات والتنقلات', 0, 0, 'R');
	// Add image at the top middle of the page
	$imageFile = 'Oman.png';
	$pdf->Image($imageFile, 95, 27, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        // التحقق مما إذا كان هناك سجلات تطابق البيانات المدخلة
        if ($result->num_rows > 0) {
            // عرض بيانات المستخدم
            while ($row = $result->fetch_assoc()) {
            //    echo "اسم المستخدم: " . $roappme'] . "<br>";
                //echo "رقم موبايله: " . $row['mobile'] . "<br>";
                // وما إلى ذلك - قم بتعديله حسب هيكلة جدول قاعدة البيانات الخاصة بك
		// Set form field positions
        $pdf->SetFont('aealarabiya', '', 17);
        $pdf->SetXY(60, 60);
        $pdf->SetLineWidth(0.4);
        $pdf->Ellipse(105,75,35,8);
		$pdf->SetXY(20, 70);
		$pdf->Cell(170, 10, '"إقرار استلام عمل"', 0, 0, 'C');
        
        $pdf->SetFont('aealarabiya', '', 15);
		$pdf->SetXY(20, 100);
       	$pdf->Cell(170, 10, 'أقر أنا   '.$row['emp_name'],0, 0, 'R');
       	$pdf->SetXY(20, 101);
		$pdf->Cell(170, 10, '_____________________________________________________________', 0, 0, 'R');
        
		$pdf->SetXY(20, 115);
		$pdf->Cell(170, 10,'الموظف بالدرجة : الحادية عشر   '.'                                '.'أعمل بوظيفة:'.$row['job_desc'],0, 0, 'R');
		
		$pdf->SetXY(20, 128);
		$pdf->Cell(170, 10, 'بأنني استلمت العمل إعتباراً من:    /      /               م ', 0, 0, 'R');

		$pdf->SetXY(20, 142);
		$pdf->Cell(170, 10, 'بقسم / بمدرسة : '.$row['school'], 0, 0, 'R');
		
		$pdf->SetXY(20, 158);
		$pdf->Cell(170, 10, 'توقيع مدير/مديرة المدرسة '.'                           '.'توقيع صاحب العلاقة',0, 0, 'C');
           

		$pdf->SetXY(20, 169);
		$pdf->Cell(170, 10, '___________________'.'                 '.'_____________________',0, 0, 'C');
		
		$pdf->SetFont('aealarabiya', '', 13);
		$pdf->SetXY(20, 195);
		$pdf->Cell(170, 10, 'التاريخ:       /        /          م', 0, 0, 'R');
		$pdf->SetXY(20, 197);
		$pdf->Cell(170, 10, '___________________________________________________________________', 0, 0, 'R');
        
        $pdf->SetFont('aealarabiya', '', 10);
		$pdf->SetXY(20, 218);
		$pdf->Cell(170, 10, 'تحررا في:      /         /                     م', 0, 0, 'R');

		$pdf->SetFont('aealarabiya', '', 12.5);
		$pdf->SetXY(20, 217);
		$pdf->Cell(170, 10, 'يعتمد...', 0, 0, 'L');
		$pdf->SetXY(20, 222);
		$pdf->Cell(170, 10, 'مدير دائرة الشؤون الإدارية', 0, 0, 'L');


            }
        } else {
            echo "لا توجد بيانات مطابقة في قاعدة البيانات.";
        }

        // إغلاق اتصال قاعدة البيانات
        $conn->close();
    } else {
        echo "يرجى تعبئة جميع الحقول.";
    }
// Generate PDF content as a string
$pdfContent = $pdf->Output('إقرار إستلام عمل', 'I');

// Send appropriate headers for displaying the PDF in the browser
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="إقرار إستلام عمل.pdf"');

// Output the PDF content
echo $pdfContent;
}


?>
