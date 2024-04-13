<?php
require_once "../../config.php";
require_once "../../Models/user.php";
require_once "../../Controllers/userC.php";

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$user = $_SESSION["user"];
$email = $user->getEmail();

// Fetch user data from the database based on the logged-in user
$pdo = config::getConnexion();
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    // Fetch user data
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: ../Auth/login.php");
    exit(); // Terminate script execution after redirection
}

$sql = "SELECT name FROM countries";
$stmt = $pdo->query($sql);
$countries = $stmt->fetchAll(PDO::FETCH_COLUMN);

$country_sql = "SELECT name FROM countries WHERE id = ?";
$country_sql_run = $pdo->prepare($country_sql);
$country_sql_run->execute([$userData['country_id']]);
$countryId = $country_sql_run->fetchColumn();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["edit_profile"])) {
        $userController = new UserC();
        $userController->edit_profile($email);
    } elseif (isset($_POST["add_post"])) {
        $postController = new JobC();
        $postController->add_post();
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
</head>

<body>
    <div class="backdrop"></div>
    <div class="edit_modal">
        <form action="profilee.php" method="post" enctype="multipart/form-data">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so
                        be
                        careful what you share.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="Fullname"
                                class="block text-sm font-medium leading-6 text-gray-900">Fullname</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <span
                                        class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">HireEm.com/</span>
                                    <input type="text" name="Fullname" id="Fullname" autocomplete="Fullname"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        value="<?php echo $userData['fullname']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="Phone_num" class="block text-sm font-medium leading-6 text-gray-700">Phone
                                Number</label>
                            <div class="mt-2">
                                <input id="Phone_num" name="Phone_num" type="text" autocomplete="Phone_num"
                                    value="<?php echo $userData['phone_num']; ?>"
                                    class="p-2 block w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">About</label>
                            <div class="mt-2">
                                <textarea id="about" name="about" rows="3"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?php echo $userData['about']; ?></textarea>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.
                            </p>
                        </div>

                        <div class="col-span-full">
                            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
                            <div class="mt-2 flex items-center gap-x-3">
                                <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="flex text-sm leading-6 text-gray-600">
                                    <label for="profile_pic" class="relative cursor-pointer">
                                        <span
                                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                            Change
                                        </span>
                                        <input id="profile_pic" name="profile_pic" type="file" class="sr-only"
                                            accept="image/*">
                                    </label>
                                </div>


                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover
                                photo</label>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                        <label for="cover_upload"
                                            class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="cover_upload" name="cover_upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can receive
                        mail.
                    </p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="EducationLvl" class="block text-sm font-medium leading-6 text-gray-900">Level of
                                Education</label>
                            <div class="mt-2">
                                <input type="text" name="EducationLvl" id="EducationLvl" autocomplete="education-level"
                                    value="<?php echo $userData['education']; ?>"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="Education_ins"
                                class="block text-sm font-medium leading-6 text-gray-900">Education
                                Institution</label>
                            <div class="mt-2">
                                <input type="text" name="Education_ins" id="Education_ins"
                                    autocomplete="Education-Institution" value="<?php echo $userData['school']; ?>"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                Address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" value=<?php echo $email; ?>
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    readonly>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="country"
                                class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                            <div class="mt-2">
                                <select id="country" name="country" autocomplete="country-name"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <?php
                                    // Loop through the countries fetched from the database and populate the options
                                    foreach ($countries as $country) {
                                        echo "<option>$country</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>



                        <div class="sm:col-span-2 sm:col-start-1">
                            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                            <div class="mt-2">
                                <input type="text" name="city" id="city" autocomplete="address-level2"
                                    value="<?php echo $userData['City']; ?>"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>



                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Notifications</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">We'll always let you know about important
                        changes,
                        but you pick what else you want to hear about.</p>

                    <div class="mt-10 space-y-10">
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">By Email</legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="comments" name="comments" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="comments" class="font-medium text-gray-900">Comments</label>
                                        <p class="text-gray-500">Get notified when someones posts a comment on a
                                            posting.</p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="candidates" name="candidates" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="candidates" class="font-medium text-gray-900">Candidates</label>
                                        <p class="text-gray-500">Get notified when a candidate applies for a job.
                                        </p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="offers" name="offers" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="offers" class="font-medium text-gray-900">Offers</label>
                                        <p class="text-gray-500">Get notified when a candidate accepts or rejects an
                                            offer.</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">Push Notifications
                            </legend>
                            <p class="mt-1 text-sm leading-6 text-gray-600">These are delivered via SMS to your
                                mobile
                                phone.</p>
                            <div class="mt-6 space-y-6">
                                <div class="flex items-center gap-x-3">
                                    <input id="push-everything" name="push-notifications" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="push-everything"
                                        class="block text-sm font-medium leading-6 text-gray-900">Everything</label>
                                </div>
                                <div class="flex items-center gap-x-3">
                                    <input id="push-email" name="push-notifications" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="push-email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Same as
                                        email</label>
                                </div>
                                <div class="flex items-center gap-x-3">
                                    <input id="push-nothing" name="push-notifications" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="push-nothing"
                                        class="block text-sm font-medium leading-6 text-gray-900">No push
                                        notifications</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                <button type="submit" name="edit_profile"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>
    <div class="post_modal">
        <form action="profilee.php" method="post" enctype="multipart/form-data">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Create a post </h2>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="Employer"
                                class="block text-sm font-medium leading-6 text-gray-900">Employer</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                                    <input type="text" name="Employer" id="Employer" autocomplete="Employer"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="jobTitle" class="block text-sm font-medium leading-6 text-gray-700">Job
                                Title</label>
                            <div class="mt-2">
                                <input id="jobTitle" name="jobTitle" type="text" autocomplete="jobTitle"
                                    class="p-2 block w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Type of
                                job</label>
                            <div class="mt-2">
                                <select id="country" name="country" autocomplete="country-name"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="Permanent">Permanent</option>
                                    <option value="temporary">Temporary</option>
                                    <option value="contract">Contract</option>
                                    <option value="full_time">Full-time </option>
                                    <option value="part_time">Part-time </option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="location"
                                class="block text-sm font-medium leading-6 text-gray-900">Location</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                                    <input type="text" name="location" id="location" autocomplete="Employer"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                                    <input type="text" name="city" id="city" autocomplete="city"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="experience" class="block text-sm font-medium leading-6 text-gray-900">Preferred
                                Year Of Experience</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="experience" id="experience" autocomplete="experience"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="industry"
                                class="block text-sm font-medium leading-6 text-gray-900">Industry</label>
                            <div class="mt-2">
                                <select id="industry" name="industry" autocomplete="industry"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="marketing">IT</option>
                                    <option value="finance">Finance</option>
                                    <option value="engineering">Engineering</option>
                                    <option value="legal">Legal</option>
                                    <option value="sales">sales</option>
                                    <option value="banking">Banking</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="job_function" class="block text-sm font-medium leading-6 text-gray-900">Job
                                Function</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="job_function" id="job_function" autocomplete="job_function"
                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="degree" class="block text-sm font-medium leading-6 text-gray-900">Degree</label>
                            <div class="mt-2">
                                <select id="degree" name="degree" autocomplete="degree"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="no_degree">No degree</option>
                                    <option value="bachelor">Bachelor</option>
                                    <option value="masters">Masters</option>
                                    <option value="phd">PHD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Job description</h2>
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="description"
                                class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="5"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="attachments"
                                class="block text-sm font-medium leading-6 text-gray-900">Attachments</label>
                            <div class="mt-2">
                                <input id="attachments" name="attachments[]" type="file" multiple
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <p class="mt-2 text-sm text-gray-500">You can upload one or more files.</p>
                            </div>
                        </div>


                        <div class="sm:col-span-4">
                            <label for="salary" class="block text-sm font-medium leading-6 text-gray-900">Salary</label>
                            <div class="mt-2">
                                <input id="salary" name="salary" type="salary" autocomplete="salary"
                                    class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Notifications</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">We'll always let you know about important
                        changes,
                        but you pick what else you want to hear about.</p>

                    <div class="mt-10 space-y-10">
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">By Email</legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="comments" name="comments" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="comments" class="font-medium text-gray-900">Comments</label>
                                        <p class="text-gray-500">Get notified when someones posts a comment on a
                                            posting.</p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="candidates" name="candidates" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="candidates" class="font-medium text-gray-900">Candidates</label>
                                        <p class="text-gray-500">Get notified when a candidate applies for a job.
                                        </p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="offers" name="offers" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="offers" class="font-medium text-gray-900">Offers</label>
                                        <p class="text-gray-500">Get notified when a candidate accepts or rejects an
                                            offer.</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">Push Notifications
                            </legend>
                            <p class="mt-1 text-sm leading-6 text-gray-600">These are delivered via SMS to your
                                mobile
                                phone.</p>
                            <div class="mt-6 space-y-6">
                                <div class="flex items-center gap-x-3">
                                    <input id="push-everything" name="push-notifications" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="push-everything"
                                        class="block text-sm font-medium leading-6 text-gray-900">Everything</label>
                                </div>
                                <div class="flex items-center gap-x-3">
                                    <input id="push-email" name="push-notifications" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="push-email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Same as
                                        email</label>
                                </div>
                                <div class="flex items-center gap-x-3">
                                    <input id="push-nothing" name="push-notifications" type="radio"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="push-nothing"
                                        class="block text-sm font-medium leading-6 text-gray-900">No push
                                        notifications</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                <button type="submit" name="add_post"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add
                    Post</button>
            </div>
        </form>
    </div>
    <?php
    $IPATH = $_SERVER["DOCUMENT_ROOT"] . "/login2/Public/";
    include ($IPATH . "header.php")
        ?>

    <div class="profile-container">
        <!-- Profile page content here -->
        <div class="profile_header">
            <!-- Display user's profile picture and cover image -->
            <div class="profile_images">
                <img src="<?php echo $userData['CoverImg']; ?>" class="cover-img">
                <div class="pdp_container">
                    <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                    <span></span>
                </div>
            </div>
            <div class="profile_description">
                <div class="edit">
                    <a><img src=" ../../Public/images/pen.png" alt="Freelancer"></a>
                </div>
                <h1>
                    <?php echo $userData['fullname']; ?>
                </h1>
                <!-- Add user's description and social media links here -->
                <div class="social_media">
                    <ul>
                        <li><i class="fab fa-twitter"></i></li>
                        <li><i class="fab fa-pinterest"></i></li>
                        <li><i class="fab fa-facebook"></i></li>
                        <li><i class="fab fa-dribbble"></i></li>
                    </ul>
                </div>
                <h2>About :</h2>
                <div class="about_section">
                    <?php echo $userData['about']; ?>
                </div>
                <div class="Post_btn">
                    <a class="PostBtn login-button">Post</a>
                </div>
            </div>
        </div>
        <div class="profile_info">
            <div class="info_col">
                <div class="profile_intro">
                    <ul>
                        <li><img src="../../Public/images/camera.png">
                            <?php echo $userData['school']; ?>
                        </li>
                        <li><img src="../../Public/images/camera.png">
                            <?php echo $countryId; ?>,
                            <?php
                            echo $userData['City']; ?>
                        </li>
                        <li><img src="../../Public/images/camera.png">
                            <?php echo $userData['education']; ?>
                        </li>
                        <li><img src="../../Public/images/camera.png">Something</li>
                        <li><img src="../../Public/images/camera.png">Something</li>
                    </ul>
                </div>

            </div>
            <div class="post_col">
                <div class="write-post-container">
                    <div class="user-profile">
                        <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                        <div>
                            <p>
                                <?php echo $userData['fullname']; ?>
                            </p>
                            <small>Public <i class="fas fa-caret-down"></i></small>
                        </div>
                    </div>
                    <div class="post-input-container">
                        <textarea rows="3" placeholder="What's on ur mind?"></textarea>
                        <div class="add-post-links">
                            <a href="#"><img src="../../Public/images/camera.png" alt="">Live Video</a>
                            <a href="#"><img src="../../Public/images/image.png" alt="">Photo/Video</a>
                            <a href="#"><img src="../../Public/images/feedback.png" alt="">Feeling/Activity</a>
                        </div>
                    </div>

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/1.jpg">

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/2.jpg">

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/3.jpg">

                </div>
                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <img src="<?php echo $userData['ProfilePic']; ?>" alt="profile pic">
                            <div>
                                <p>
                                    <?php echo $userData['fullname']; ?>
                                </p>
                                <span>March 21 2024, 3:36 pm</span>
                            </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="post-text">All alone in peace</p>
                    <img class="post_img" src="../../Public/images/3.jpg">

                </div>
            </div>


        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>