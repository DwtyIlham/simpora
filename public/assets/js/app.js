(function ($) {
  "use strict";

  const sidebar = $(".sidebar");
  const dashboardMain = $(".dashboard-main");
  const desktopToggle = $(".sidebar-toggle");

  function closeMobileSidebar() {
    if (!sidebar.hasClass("sidebar-open")) {
      return;
    }

    sidebar.removeClass("sidebar-open");
    $("body").removeClass("overlay-active");
    $(".sidebar-mobile-toggle").attr("aria-expanded", "false");
  }

  // Sidebar submenu collapsible (only the direct parent link)
  $(".sidebar-menu .dropdown > a").on("click", function (event) {
    event.preventDefault();

    const parent = $(this).parent();
    const submenu = parent.children(".sidebar-submenu");
    const isOpen = parent.hasClass("open") || parent.hasClass("dropdown-open");

    parent
      .siblings(".dropdown")
      .removeClass("open dropdown-open")
      .children(".sidebar-submenu")
      .stop(true, true)
      .slideUp(180);
    parent.siblings(".dropdown").children("a").attr("aria-expanded", "false");

    if (isOpen) {
      parent.removeClass("open dropdown-open");
      submenu.stop(true, true).slideUp(180);
      $(this).attr("aria-expanded", "false");
    } else {
      parent.addClass("open dropdown-open");
      submenu.stop(true, true).slideDown(180);
      $(this).attr("aria-expanded", "true");
    }
  });

  // Remember the desktop sidebar state.
  if (
    window.innerWidth >= 1200 &&
    localStorage.getItem("silagapora.sidebar") === "collapsed"
  ) {
    sidebar.addClass("active");
    dashboardMain.addClass("active");
    desktopToggle.addClass("active");
  }

  desktopToggle.attr("aria-expanded", !sidebar.hasClass("active"));

  desktopToggle.on("click", function () {
    $(this).toggleClass("active");
    sidebar.toggleClass("active");
    dashboardMain.toggleClass("active");
    $(this).attr("aria-expanded", !sidebar.hasClass("active"));
    localStorage.setItem(
      "silagapora.sidebar",
      sidebar.hasClass("active") ? "collapsed" : "expanded"
    );
  });

  $(".sidebar-mobile-toggle").on("click", function () {
    sidebar.addClass("sidebar-open");
    $("body").addClass("overlay-active");
    $(this).attr("aria-expanded", "true");
  });

  $(".sidebar-close-btn").on("click", closeMobileSidebar);

  $("body").on("click", function (event) {
    if ($(event.target).is("body.overlay-active")) {
      closeMobileSidebar();
    }
  });

  $(document).on("keydown", function (event) {
    if (event.key === "Escape") {
      closeMobileSidebar();
    }
  });

  $(window).on("resize", function () {
    if (window.innerWidth >= 1200) {
      closeMobileSidebar();
    }
  });

  // Keep the current page active and open its parent menu.
  $(function () {
    const current = new URL(window.location.href);

    $("ul#sidebar-menu a").each(function () {
      const href = this.getAttribute("href");
      if (!href || href === "#" || href.indexOf("javascript:") === 0) {
        return;
      }

      const link = new URL(this.href, window.location.origin);
      if (link.pathname !== current.pathname || link.search !== current.search) {
        return;
      }

      const anchor = $(this);
      anchor.addClass("active-page").attr("aria-current", "page");
      anchor.parent().addClass("active-page");

      const dropdown = anchor.closest(".dropdown");
      if (dropdown.length) {
        dropdown
          .addClass("open")
          .children("a")
          .attr("aria-expanded", "true");
        dropdown.children(".sidebar-submenu").show();
      }

      const activeItem = anchor.closest("li")[0];
      if (activeItem) {
        requestAnimationFrame(function () {
          activeItem.scrollIntoView({ block: "nearest" });
        });
      }
    });
  });

  /**
   * Utility function to calculate the current theme setting based on localStorage.
   */
  function calculateSettingAsThemeString({ localStorageTheme }) {
    if (localStorageTheme !== null) {
      return localStorageTheme;
    }
    return "light"; // default to light theme if nothing is stored
  }

  /**
   * Utility function to update the button text and aria-label.
   */
  function updateButton({ buttonEl, isDark }) {
    const newCta = isDark ? "dark" : "light";
    buttonEl.setAttribute("aria-label", newCta);
    buttonEl.innerText = newCta;
  }

  /**
   * Utility function to update the theme setting on the html tag.
   */
  function updateThemeOnHtmlEl({ theme }) {
    document.querySelector("html").setAttribute("data-theme", theme);
  }

  /**
   * 1. Grab what we need from the DOM and system settings on page load.
   */
  const button = document.querySelector("[data-theme-toggle]");
  const localStorageTheme = localStorage.getItem("theme");

  /**
   * 2. Work out the current site settings.
   */
  let currentThemeSetting = calculateSettingAsThemeString({
    localStorageTheme,
  });

  /**
   * 3. If the button exists, update the theme setting and button text according to current settings.
   */
  if (button) {
    updateButton({ buttonEl: button, isDark: currentThemeSetting === "dark" });
    updateThemeOnHtmlEl({ theme: currentThemeSetting });

    /**
     * 4. Add an event listener to toggle the theme.
     */
    button.addEventListener("click", (event) => {
      const newTheme = currentThemeSetting === "dark" ? "light" : "dark";

      localStorage.setItem("theme", newTheme);
      updateButton({ buttonEl: button, isDark: newTheme === "dark" });
      updateThemeOnHtmlEl({ theme: newTheme });

      currentThemeSetting = newTheme;
    });
  } else {
    // If no button is found, just apply the current theme to the page
    updateThemeOnHtmlEl({ theme: currentThemeSetting });
  }

  // =========================== Dark and light mode from sidebar js Start ================================
  const buttons = document.querySelectorAll(".dark-light-mode .theme-btn");

  function applyTheme(theme) {
    if (theme === "system") {
      const prefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
      ).matches;
      document.documentElement.setAttribute(
        "data-theme",
        prefersDark ? "dark" : "light"
      );
    } else {
      document.documentElement.setAttribute("data-theme", theme);
    }
  }

  buttons.forEach((button) => {
    button.addEventListener("click", () => {
      const theme = button.getAttribute("data-theme");

      // Apply theme
      applyTheme(theme);

      // Save in localStorage
      localStorage.setItem("theme", theme);

      // Remove active from all buttons
      buttons.forEach((btn) => btn.classList.remove("active"));

      // Add active to clicked button
      button.classList.add("active");
    });
  });

  // Load theme on page refresh
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme) {
    applyTheme(savedTheme);
    buttons.forEach((btn) => {
      if (btn.getAttribute("data-theme") === savedTheme) {
        btn.classList.add("active");
      }
    });
  }
  // =========================== Dark and light mode from sidebar js Start ================================

  // =========================== Theme Customization Show Hide js Start ================================
  $(".theme-customization__button").on("click", function () {
    $(".theme-customization-sidebar").toggleClass("active");
    $(".body-overlay").toggleClass("show");
  });

  $(".theme-customization-sidebar__close, .body-overlay").on(
    "click",
    function () {
      $(".theme-customization-sidebar").removeClass("active");
      $(".body-overlay").removeClass("show");
    }
  );
  // =========================== Theme Customization Show Hide js End ================================

  // =========================== RTL Mode js Start ================================
  $(".ltr-mode-btn").on("click", function () {
    $("html").attr("dir", "ltr");
    localStorage.setItem("direction", "ltr");

    // Toggle active state
    $(".theme-setting-item__btn").removeClass("active");
    $(this).addClass("active");
  });

  // RTL button
  $(".rtl-mode-btn").on("click", function () {
    $("html").attr("dir", "rtl");
    localStorage.setItem("direction", "rtl");

    // Toggle active state
    $(".theme-setting-item__btn").removeClass("active");
    $(this).addClass("active");
  });

  // Load saved direction from localStorage on page load
  $(document).ready(function () {
    const savedDir = localStorage.getItem("direction");
    if (savedDir) {
      $("html").attr("dir", savedDir);

      // Keep correct button active
      if (savedDir === "rtl") {
        $(".rtl-mode-btn").addClass("active");
      } else {
        $(".ltr-mode-btn").addClass("active");
      }
    }
  });
  // =========================== RTL Mode js End ================================

  // =========================== Color Schema js Start ================================
  // const colorPickerButtons = document.querySelectorAll(".color-picker-btn");

  // const colors = {
  //   blue: "#2563eb",
  //   red: "#dc2626",
  //   green: "#16a34a",
  //   yellow: "#ff9f29",
  //   cyan: "#00b8f2",
  //   violet: "#7c3aed",
  // };

  // function applyColor(color) {
  //   document.documentElement.style.setProperty("--primary-600", colors[color]);
  //   localStorage.setItem("templateColor", color);
  // }

  // colorPickerButtons.forEach((btn) => {
  //   btn.addEventListener("click", () => {
  //     const color = btn.getAttribute("data-color");

  //     // Apply color
  //     applyColor(color);

  //     // Active state
  //     colorPickerButtons.forEach((b) => b.classList.remove("active"));
  //     btn.classList.add("active");
  //   });
  // });

  // // Load saved color on refresh
  // const savedColor = localStorage.getItem("templateColor");
  // if (savedColor && colors[savedColor]) {
  //   applyColor(savedColor);
  //   document
  //     .querySelector(`.color-picker-btn[data-color="${savedColor}"]`)
  //     .classList.add("active");
  // } else {
  //   // Default (blue)
  //   document
  //     .querySelector(`.color-picker-btn[data-color="blue"]`)
  //     .classList.add("active");
  // }

  const colorPickerButtons = document.querySelectorAll(".color-picker-btn");

  const colors = {
    blue: "#2563eb",
    red: "#dc2626",
    green: "#16a34a",
    yellow: "#ff9f29",
    cyan: "#00b8f2",
    violet: "#7c3aed",
  };

  function applyColor(color) {
    document.documentElement.style.setProperty("--primary-600", colors[color]);
    localStorage.setItem("templateColor", color);
  }

  colorPickerButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const color = btn.getAttribute("data-color");

      if (!color) return; // safety

      // Apply color
      applyColor(color);

      // Instantly update active state
      colorPickerButtons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
    });
  });

  // Load saved color on refresh
  const savedColor = localStorage.getItem("templateColor");
  if (savedColor && colors[savedColor]) {
    applyColor(savedColor);

    const savedColorButton = document.querySelector(
      `.color-picker-btn[data-color="${savedColor}"]`
    );
    if (savedColorButton) {
      savedColorButton.classList.add("active");
    }
  } else {
    // Default (blue)
    const defaultColorButton = document.querySelector(
      '.color-picker-btn[data-color="blue"]'
    );
    if (defaultColorButton) {
      defaultColorButton.classList.add("active");
    }
  }
  // =========================== Color Schema js End ================================

  // =========================== Table Header Checkbox checked all js Start ================================
  $("#selectAll").on("change", function () {
    $(".form-check .form-check-input").prop("checked", $(this).prop("checked"));
  });

  // Remove Table Tr when click on remove btn start
  $(".remove-btn").on("click", function () {
    $(this).closest("tr").remove();

    // Check if the table has no rows left
    if ($(".table tbody tr").length === 0) {
      $(".table").addClass("bg-danger");

      // Show notification
      $(".no-items-found").show();
    }
  });
  // Remove Table Tr when click on remove btn end
})(jQuery);
