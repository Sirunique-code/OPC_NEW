<x-guest-layout>

<!-- Plagiarism Checker Section -->
<!-- Plagiarism Checker Section -->
<section id="plagiarism-checker" class="plagiarism-checker section">
  <div class="container section-title" data-aos="fade-up">
    <span>Check Plagiarism</span>
    <h2>Compare Two Contents</h2>
    <p>Upload or paste two texts for plagiarism analysis between town content, essays, or any written material.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100" style="border: 2px black">
    <div class="row g-5">

      <!-- Left Column - Content Input -->
      <div class="col-lg-6 d-flex flex-column justify-content-between h-100">
        <form id="plagiarismForm" class="needs-validation" novalidate>
          <!-- First Text Area -->
          {{-- <label for="text1" class="form-label"><strong>Content 1 (e.g., Town A)</strong></label> --}}
          <textarea id="text1" name="text1" class="form-control mb-3" rows="6" placeholder="Paste first content here..."></textarea>
          <input type="file" id="file1" class="form-control mb-4" accept=".txt,.pdf,.doc,.docx">

          <!-- Second Text Area -->
          {{-- <label for="text2" class="form-label"><strong>Content 2 (e.g., Town B)</strong></label> --}}
          <textarea id="text2" name="text2" class="form-control mb-3" rows="6" placeholder="Paste second content here..."></textarea>
          <input type="file" id="file2" class="form-control mb-4" accept=".txt,.pdf,.doc,.docx">

          <!-- Submit Button -->
          <button type="submit" class="btn btn-success w-100">Check Plagiarism</button>
        </form>

        <!-- Results Area -->
        <div id="result" class="mt-5 p-4 bg-light rounded shadow-sm" style="display: none;">
          <h5>Results:</h5>
          <p><strong>Similarity Percentage:</strong> <span id="similarityPercentage">0%</span></p>
          <p><strong>Detailed Comparison:</strong></p>
          <div id="comparisonResult" class="border p-3 bg-white rounded small">
            No result yet. Please submit two contents above.
          </div>
        </div>
      </div>

      <!-- Right Column - Instructions -->
      <div class="col-lg-6 d-flex align-items-start h-100">
        <div class="instruction-box p-4 bg-white border rounded shadow-sm w-100">
          <h5 class="mb-3">
            <img src="assets/img/logo.png" alt="Logo" width="30" class="me-2"> <!-- Optional Logo -->
            Let's get started.
          </h5>
          <ol class="ps-4">
            <li>Add your text or upload a file (TXT, PDF, DOC).</li>
            <li>Click the "Check Plagiarism" button.</li>
            <li>Review the results for similarity percentage and highlighted differences.</li>
          </ol>
          <p class="text-muted mt-3">
            Our tool helps detect copied or paraphrased content while preserving your privacy.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js "></script>
<script>
document.getElementById('plagiarismForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const text1 = document.getElementById('text1').value.trim();
  const text2 = document.getElementById('text2').value.trim();
  const file1 = document.getElementById('file1').files[0];
  const file2 = document.getElementById('file2').files[0];

  let content1 = text1 || (file1 ? await readFile(file1) : '');
  let content2 = text2 || (file2 ? await readFile(file2) : '');

  if (!content1 || !content2) {
    alert("Please enter or upload both contents.");
    return;
  }

  // Display extracted content (for testing)
  console.log("Content 1:", content1);
  console.log("Content 2:", content2);

  // Simulate similarity check
  const similarity = calculateSimilarity(content1, content2);
  const percentage = Math.round(similarity * 100);

  document.getElementById('similarityPercentage').textContent = percentage + '%';
  document.getElementById('comparisonResult').innerHTML = highlightDifferences(content1, content2);
  document.getElementById('result').style.display = 'block';
});

// Helper: Read different file types
async function readFile(file) {
  const reader = new FileReader();
  return new Promise((resolve, reject) => {
    reader.onload = async function(e) {
      const binary = e.target.result;

      if (file.type === 'application/pdf') {
        const pdfText = await extractTextFromPDF(binary);
        resolve(pdfText);
      } else if (file.type === 'application/msword' ||
                 file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
        alert("Word document reading not supported yet.");
        resolve('');
      } else {
        resolve(e.target.result); // Plain text
      }
    };
    reader.onerror = () => reject(reader.error);
    reader.readAsBinaryString(file);
  });
}

// PDF extraction using pdf.js
async function extractTextFromPDF(data) {
  const typedArray = new Uint8Array([...data].map(c => c.charCodeAt(0)));
  const pdf = await pdfjsLib.getDocument({ data: typedArray }).promise;
  let fullText = '';
  for (let i = 1; i <= pdf.numPages; i++) {
    const page = await pdf.getPage(i);
    const textContent = await page.getTextContent();
    const strings = textContent.items.map(item => item.str).join(' ');
    fullText += strings + ' ';
  }
  return fullText.trim();
}

// Similarity logic from earlier
function calculateSimilarity(str1, str2) {
  const set1 = new Set(str1.toLowerCase().split(/\s+/));
  const set2 = new Set(str2.toLowerCase().split(/\s+/));

  const intersection = [...set1].filter(x => set2.has(x)).length;
  const union = [...new Set([...set1, ...set2])].length;

  return union === 0 ? 0 : intersection / union;
}

function highlightDifferences(a, b) {
  const wordsA = a.split(' ');
  const wordsB = b.split(' ');

  let output = '';
  let minLength = Math.min(wordsA.length, wordsB.length);

  for (let i = 0; i < minLength; i++) {
    if (wordsA[i] === wordsB[i]) {
      output += `<span>${wordsA[i]}</span> `;
    } else {
      output += `<span class="text-danger fw-bold">${wordsA[i]}</span>/<span class="text-success fw-bold">${wordsB[i]}</span> `;
    }
  }

  for (let i = minLength; i < wordsA.length; i++) {
    output += `<span class="text-danger fw-bold">${wordsA[i]}*</span> `;
  }
  for (let i = minLength; i < wordsB.length; i++) {
    output += `<span class="text-success fw-bold">${wordsB[i]}*</span> `;
  }

  return output;
}
</script>

</x-guest-layout>
