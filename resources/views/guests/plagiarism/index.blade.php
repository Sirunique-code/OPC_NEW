<x-guest-layout>

    <!-- Plagiarism Checker Section -->
    <section class="plagiarism-checker-section">
        <!-- Title Section -->
        <div class="section-title plagiarism-checker-title text-center mb-5">
            <span>Check Plagiarism</span>
            <h2>Compare Two Contents</h2>
            <p>Upload or paste two texts for plagiarism analysis between town content, essays, or any written material.
            </p>
        </div>

        <!-- Main Content Layout -->
        <div class="container border p-4" data-aos="fade-up">
            <div class="row g-5">
                <!-- Left Column - Content Input -->
                <div class="col-lg-8">
                    <form id="plagiarismForm" class="needs-validation" novalidate>

                        <!-- First Content Group -->
                        <div class="content-group-container mb-4">
                            <div class="input-group-wrapper p-3">
                                <!-- Text Area -->
                                <textarea id="text1" name="text1" class="input-textarea-custom form-control" rows="6"
                                    placeholder="Paste first content here..." style="resize: none"></textarea>

                                <!-- File Upload Section -->
                                <div class="file-input-container mt-3">
                                    <label for="file1" class="file-input-label">
                                        <span class="file-input-button">Choose File</span>
                                        <i class="fas fa-upload"></i>
                                    </label>
                                    <input type="file" id="file1" class="file-input-hidden"
                                        accept=".txt,.pdf,.doc,.docx">
                                    <p id="file1-placeholder" class="file-input-placeholder ms-2 mt-1 mb-0">No file
                                        chosen</p>
                                </div>
                            </div>
                        </div>

                        <!-- Second Content Group -->
                        <div class="content-group-container mb-4">
                            <div class="input-group-wrapper p-3">
                                <!-- Text Area -->
                                <textarea id="text2" name="text2" class="input-textarea-custom form-control" rows="6"
                                    placeholder="Paste second content here..." style="resize: none"></textarea>

                                <!-- File Upload Section -->
                                <div class="file-input-container mt-3">
                                    <label for="file2" class="file-input-label">
                                        <span class="file-input-button">Choose File</span>
                                        <i class="fas fa-upload"></i>
                                    </label>
                                    <input type="file" id="file2" class="file-input-hidden"
                                        accept=".txt,.pdf,.doc,.docx">
                                    <p id="file2-placeholder" class="file-input-placeholder ms-2 mt-1 mb-0">No file
                                        chosen</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <button type="submit" class="submit-button-custom btn btn-primary">
                                Check Plagiarism
                            </button>
                            <!-- Reset Icon -->
                            <button type="button" id="resetButton"
                                class="reset-button-custom btn btn-outline-secondary" title="Reset Form">
                                <i class="fas fa-redo me-1"></i> Reset
                            </button>
                        </div>
                    </form>

                    <!-- Results Area -->
                    <div id="result" class="result-box-custom mt-5" style="display: none;">
                        <h5>Results:</h5>
                        <p><strong>Similarity Percentage:</strong> <span id="similarityPercentage"
                                class="similarity-percentage-custom">0%</span></p>
                        <p><strong>Detailed Comparison:</strong></p>
                        <div id="comparisonResult" class="comparison-result-custom">
                            No result yet. Please submit two contents above.
                        </div>
                    </div>
                </div>

                <!-- Right Column - Instructions -->
                <div class="col-lg-4">
                    <div class="instruction-box-custom w-100">
                        <h5 class="mb-3">
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
        document.addEventListener("DOMContentLoaded", function() {


            // Form Submission
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

                const similarityElement = document.getElementById('similarityPercentage');
                similarityElement.textContent = percentage + '%';
                similarityElement.style.color = percentage > 50 ? '#dc3545' : '#28a745';

                document.getElementById('comparisonResult').innerHTML = highlightDifferences(content1,
                    content2);
                document.getElementById('result').style.display = 'block';
            });

            // Read different file types
            async function readFile(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();

                    reader.onload = async function(e) {
                        const result = e.target.result;

                        if (file.type === 'application/pdf') {
                            const pdfText = await extractTextFromPDF(result);
                            resolve(pdfText);

                        } else if (file.name.endsWith('.docx')) {
                            try {
                                const docxResult = await mammoth.convertToText({
                                    arrayBuffer: result
                                });
                                resolve(docxResult.value);

                            } catch (err) {
                                console.error("DOCX Error:", err);
                                resolve('');
                            }

                        } else if (file.type === 'application/msword') {
                            alert(".doc format is not supported yet.");
                            resolve('');

                        } else {
                            // For .txt and other plain text files
                            resolve(result); // This should now be correct
                        }
                    };

                    reader.onerror = () => reject(reader.error);

                    // Choose the correct read method
                    if (file.type === 'text/plain' || file.name.endsWith('.txt')) {
                        reader.readAsText(file); // 👈 Read as text for .txt
                    } else {
                        reader.readAsArrayBuffer(file);
                    }
                });
            }
            // Extract text from PDF
            async function extractTextFromPDF(data) {
                const typedArray = new Uint8Array([...data].map(c => c.charCodeAt(0)));
                const pdf = await pdfjsLib.getDocument({
                    data: typedArray
                }).promise;
                let fullText = '';
                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const textContent = await page.getTextContent();
                    const strings = textContent.items.map(item => item.str).join(' ');
                    fullText += strings + ' ';
                }
                return fullText.trim();
            }

            // Similarity calculator
            function calculateSimilarity(str1, str2) {
                const set1 = new Set(str1.toLowerCase().split(/\s+/));
                const set2 = new Set(str2.toLowerCase().split(/\s+/));
                const intersection = [...set1].filter(x => set2.has(x)).length;
                const union = [...new Set([...set1, ...set2])].length;
                return union === 0 ? 0 : intersection / union;
            }

            // Highlight differences
            function highlightDifferences(a, b) {
                const wordsA = a.split(' ');
                const wordsB = b.split(' ');
                let output = '';
                let minLength = Math.min(wordsA.length, wordsB.length);

                for (let i = 0; i < minLength; i++) {
                    if (wordsA[i] === wordsB[i]) {
                        output += `<span>${wordsA[i]}</span> `;
                    } else {
                        output +=
                            `<span class="text-danger fw-bold">${wordsA[i]}</span>/<span class="text-success fw-bold">${wordsB[i]}</span> `;
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

            // Handle file selection display
            function handleFileInput(inputId, placeholderId) {
                const input = document.getElementById(inputId);
                const placeholder = document.getElementById(placeholderId);

                input.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        placeholder.textContent = this.files[0].name;
                    } else {
                        placeholder.textContent = 'No file chosen';
                    }
                });
            }

            handleFileInput('file1', 'file1-placeholder');
            handleFileInput('file2', 'file2-placeholder');

            // Reset form
            document.getElementById('resetButton').addEventListener('click', function() {
                document.getElementById('text1').value = '';
                document.getElementById('text2').value = '';
                document.getElementById('file1').value = '';
                document.getElementById('file2').value = '';
                document.getElementById('result').style.display = 'none';
                document.getElementById('file1-placeholder').textContent = 'No file chosen';
                document.getElementById('file2-placeholder').textContent = 'No file chosen';
            });
        });
    </script>


</x-guest-layout>
